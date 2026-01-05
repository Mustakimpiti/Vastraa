<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'cart';

    protected $fillable = [
        'user_id', 'session_id', 'saree_id', 
        'quantity', 'price'
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function saree()
    {
        return $this->belongsTo(Saree::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getSubtotal()
    {
        return $this->price * $this->quantity;
    }
}