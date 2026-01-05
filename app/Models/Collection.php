<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'image', 
        'banner_image', 'is_active', 'sort_order', 'launch_date'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'launch_date' => 'date',
    ];

    public function sarees()
    {
        return $this->hasMany(Saree::class);
    }

    public function activeSarees()
    {
        return $this->hasMany(Saree::class)->where('is_active', true);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}