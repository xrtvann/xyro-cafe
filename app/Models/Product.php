<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'stock_quantity',
        'image_url',
        'is_active',
        'low_stock_threshold',
    ];

    protected $casts = [
        'price' => 'integer',
        'stock_quantity' => 'integer',
        'is_active' => 'boolean',
        'low_stock_threshold' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
