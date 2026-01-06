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
        'quantity' => 'integer',
    ];

    /**
     * Relationships
     */
    public function saree()
    {
        return $this->belongsTo(Saree::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the subtotal for this cart item (price × quantity)
     * Returns float to ensure compatibility with number_format()
     */
    public function getSubtotal(): float
    {
        return (float)($this->price * $this->quantity);
    }

    /**
     * Get price as float
     */
    public function getPriceAttribute($value): float
    {
        return (float)$value;
    }

    /**
     * Scope: Get cart items for authenticated user
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope: Get cart items for guest session
     */
    public function scopeForSession($query, $sessionId)
    {
        return $query->where('session_id', $sessionId);
    }

    /**
     * Scope: Get cart items for current user or session
     */
    public function scopeForCurrentUser($query, $userId = null, $sessionId = null)
    {
        return $query->where(function($q) use ($userId, $sessionId) {
            if ($userId) {
                $q->where('user_id', $userId);
            } else {
                $q->where('session_id', $sessionId);
            }
        });
    }
}