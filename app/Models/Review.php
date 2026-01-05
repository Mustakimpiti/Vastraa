<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'saree_id', 'user_id', 'name', 'email',
        'rating', 'comment', 'is_approved'
    ];

    protected $casts = [
        'is_approved' => 'boolean',
    ];

    public function saree()
    {
        return $this->belongsTo(Saree::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function boot()
    {
        parent::boot();
        
        static::created(function ($review) {
            if ($review->is_approved) {
                $review->saree->updateRating();
            }
        });
        
        static::updated(function ($review) {
            $review->saree->updateRating();
        });
        
        static::deleted(function ($review) {
            $review->saree->updateRating();
        });
    }
}