<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number', 'user_id', 'first_name', 'last_name',
        'email', 'phone', 'street_address', 'apartment',
        'city', 'state', 'country', 'zip',
        'ship_to_different', 'shipping_first_name', 'shipping_last_name',
        'shipping_street_address', 'shipping_apartment',
        'shipping_city', 'shipping_state', 'shipping_country', 'shipping_zip',
        'subtotal', 'shipping_cost', 'discount', 'total',
        'payment_method', 'payment_status', 'order_status', 'order_notes'
    ];

    protected $casts = [
        'ship_to_different' => 'boolean',
        'subtotal' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'discount' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($order) {
            if (!$order->order_number) {
                $order->order_number = 'ORD-' . strtoupper(uniqid());
            }
        });
    }
}