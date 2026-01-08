<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saree extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'sku', 'description', 'short_description',
        'fabric', 'length', 'blouse_length', 'work_type', 'occasion', 
        'pattern', 'blouse_included', 'price', 'sale_price', 
        'stock_quantity', 'collection_id', 'featured_image', 
        'is_featured', 'is_new_arrival', 'is_bestseller', 'is_active',
        'colors', 'care_instructions', 'views', 'avg_rating', 'total_reviews'
    ];

    protected $casts = [
        'blouse_included' => 'boolean',
        'is_featured' => 'boolean',
        'is_new_arrival' => 'boolean',
        'is_bestseller' => 'boolean',
        'is_active' => 'boolean',
        'colors' => 'array',
        'care_instructions' => 'array',
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'length' => 'decimal:2',
        'blouse_length' => 'decimal:2',
        'avg_rating' => 'decimal:2',
    ];

    // Relationships
    public function collection()
    {
        return $this->belongsTo(Collection::class);
    }

    public function images()
    {
        return $this->hasMany(SareeImage::class)->orderBy('sort_order');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function approvedReviews()
    {
        return $this->hasMany(Review::class)->where('is_approved', true);
    }

    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Helper Methods
    public function getActivePrice()
    {
        return $this->sale_price ?? $this->price;
    }

    public function hasDiscount()
    {
        return $this->sale_price && $this->sale_price < $this->price;
    }

    public function getDiscountPercentage()
    {
        if (!$this->hasDiscount()) {
            return 0;
        }
        return round((($this->price - $this->sale_price) / $this->price) * 100);
    }

    public function isInStock()
    {
        return $this->stock_quantity > 0;
    }

    public function hasEnoughStock($quantity)
    {
        return $this->stock_quantity >= $quantity;
    }

    public function decrementStock($quantity)
    {
        if ($this->hasEnoughStock($quantity)) {
            $this->decrement('stock_quantity', $quantity);
            return true;
        }
        return false;
    }

    public function incrementStock($quantity)
    {
        $this->increment('stock_quantity', $quantity);
        return true;
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function incrementViews()
    {
        $this->increment('views');
    }

    public function updateRating()
    {
        $this->avg_rating = $this->approvedReviews()->avg('rating') ?? 0;
        $this->total_reviews = $this->approvedReviews()->count();
        $this->save();
    }

    // Scopes
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeNewArrivals($query)
    {
        return $query->where('is_new_arrival', true);
    }

    public function scopeBestsellers($query)
    {
        return $query->where('is_bestseller', true);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock_quantity', '>', 0);
    }
}