<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PosController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        
        $query = Product::where('is_active', true)->where('stock_quantity', '>', 0)->orderBy('name');
        
        if ($request->has('category') && $request->category !== '') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }
        
        if ($request->has('search') && $request->search !== '') {
            $query->where('name', 'like', "%{$request->search}%");
        }
        
        $products = $query->get()->map(function($p) {
            return [
                'id' => $p->id,
                'name' => $p->name,
                'price' => $p->price,
                'stock_quantity' => $p->stock_quantity,
                'low_stock_threshold' => $p->low_stock_threshold,
                'image_url' => $p->image_url,
                'category_name' => $p->category ? $p->category->name : 'Uncategorized',
                'category_slug' => $p->category ? $p->category->slug : ''
            ];
        });

        return view('admin.pos.index', compact('categories', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'nullable|string|max:255',
            'payment_method' => 'required|in:cash,qris',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            $subtotal = 0;
            $orderItems = [];

            // Process each item
            foreach ($request->items as $item) {
                // Pessimistic locking to prevent race condition
                $product = Product::where('id', $item['product_id'])->lockForUpdate()->first();

                if (!$product || $product->stock_quantity < $item['quantity']) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => "Insufficient stock for product: " . ($product ? $product->name : 'Unknown')
                    ], 422);
                }

                $itemSubtotal = $product->price * $item['quantity'];
                $subtotal += $itemSubtotal;

                $orderItems[] = [
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->price,
                    'subtotal' => $itemSubtotal,
                ];

                // Deduct stock
                $product->decrement('stock_quantity', $item['quantity']);
            }

            $isCash = $request->payment_method === 'cash';

            // Create Order
            $order = Order::create([
                'user_id' => Auth::id(), // Use Supabase Auth ID if available, or fallback
                'customer_name' => $request->customer_name,
                'order_type' => 'pos',
                'order_status' => $isCash ? 'completed' : 'pending',
                'payment_status' => $isCash ? 'paid' : 'unpaid',
                'payment_method' => $request->payment_method,
                'subtotal' => $subtotal,
                'shipping_cost' => 0,
                'total_amount' => $subtotal,
            ]);

            // Insert Order Items
            foreach ($orderItems as &$oi) {
                $oi['id'] = (string) \Illuminate\Support\Str::uuid();
                $oi['order_id'] = $order->id;
                $oi['created_at'] = now();
            }
            OrderItem::insert($orderItems);

            $snapToken = null;

            if (!$isCash) {
                // Configure Midtrans
                \Midtrans\Config::$serverKey = config('midtrans.server_key');
                \Midtrans\Config::$isProduction = config('midtrans.is_production');
                \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
                \Midtrans\Config::$is3ds = config('midtrans.is_3ds');

                $itemDetails = [];
                foreach ($orderItems as $oi) {
                    $itemDetails[] = [
                        'id' => $oi['product_id'],
                        'price' => $oi['unit_price'],
                        'quantity' => $oi['quantity'],
                        'name' => 'Menu Item',
                    ];
                }

                $params = [
                    'transaction_details' => [
                        'order_id' => $order->id,
                        'gross_amount' => $subtotal,
                    ],
                    'customer_details' => [
                        'first_name' => $request->customer_name ?? 'Guest',
                    ],
                    'item_details' => $itemDetails,
                ];

                $snapToken = \Midtrans\Snap::getSnapToken($params);
                
                $order->snap_token = $snapToken;
                $order->save();
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Transaction successful',
                'order_id' => $order->id,
                'snap_token' => $snapToken,
                'redirect_url' => route('admin.pos.receipt', $order->id)
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Transaction failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function receipt($id)
    {
        $order = Order::with('items.product')->findOrFail($id);
        
        // Security check (Optional): Ensure only authorized personnel can view
        
        return view('admin.pos.receipt', compact('order'));
    }

    public function webhook(\Illuminate\Http\Request $request)
    {
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');

        try {
            $notification = new \Midtrans\Notification();
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }

        $transaction = $notification->transaction_status;
        $type = $notification->payment_type;
        $order_id = $notification->order_id;
        $fraud = $notification->fraud_status;

        $order = Order::where('id', $order_id)->first();
        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order not found']);
        }

        if ($transaction == 'capture') {
            if ($fraud == 'challenge') {
                $order->payment_status = 'pending';
            } else if ($fraud == 'accept') {
                $order->payment_status = 'paid';
                $order->order_status = 'completed';
            }
        } else if ($transaction == 'settlement') {
            $order->payment_status = 'paid';
            $order->order_status = 'completed';
        } else if ($transaction == 'cancel' ||
          $transaction == 'deny' ||
          $transaction == 'expire') {
            $order->payment_status = 'failed';
            $order->order_status = 'cancelled';
            // Optional: return stock here if needed
        } else if ($transaction == 'pending') {
            $order->payment_status = 'pending';
        }

        $order->midtrans_transaction_id = $notification->transaction_id;
        $order->save();

        return response()->json(['success' => true]);
    }
}
