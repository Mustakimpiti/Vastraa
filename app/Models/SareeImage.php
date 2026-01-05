<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SareeImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'saree_id', 'image_path', 'is_primary', 'sort_order'
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    public function saree()
    {
        return $this->belongsTo(Saree::class);
    }
}