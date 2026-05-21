<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'user_id',
        'customer_name',
        'order_type',
        'order_status',
        'payment_status',
        'payment_method',
        'snap_token',
        'midtrans_order_id',
        'midtrans_transaction_id',
        'subtotal',
        'shipping_cost',
        'total_amount',
        'shipping_address',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }
}
