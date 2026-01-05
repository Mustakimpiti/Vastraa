<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'saree_id'];

    public function saree()
    {
        return $this->belongsTo(Saree::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}