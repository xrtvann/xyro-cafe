<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id'); // Cashier
            $table->string('customer_name')->nullable();
            $table->enum('order_type', ['online', 'pos'])->default('pos');
            $table->string('order_status')->default('completed');
            $table->string('payment_status')->default('paid');
            $table->string('payment_method'); // 'cash', 'qris'
            $table->string('midtrans_order_id')->nullable();
            $table->string('midtrans_transaction_id')->nullable();
            $table->integer('subtotal');
            $table->integer('shipping_cost')->default(0);
            $table->integer('total_amount');
            $table->text('shipping_address')->nullable();
            $table->timestamps();
            
            // Note: Since we are using Supabase Auth, 'user_id' might reference a UUID in auth.users, 
            // but for simplicity without constraints on external schemas, we won't add a foreign key constraint here.
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
