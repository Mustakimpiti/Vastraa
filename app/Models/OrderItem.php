<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'saree_id', 'saree_name', 'saree_sku',
        'fabric', 'quantity', 'price'
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function saree()
    {
        return $this->belongsTo(Saree::class);
    }

    public function getSubtotal()
    {
        return $this->price * $this->quantity;
    }
}