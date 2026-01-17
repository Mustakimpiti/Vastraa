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
        'stock_quantity', 'collection_id', 'featured_image','video_url',
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
    public function hasVideo()
{
    return !empty($this->video_url);
}

public function getEmbedVideoUrl()
{
    if (!$this->hasVideo()) {
        return null;
    }
    
    $url = $this->video_url;
    
    // YouTube formats
    // Standard: https://www.youtube.com/watch?v=VIDEO_ID
    if (preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/', $url, $matches)) {
        return 'https://www.youtube.com/embed/' . $matches[1] . '?rel=0';
    }
    
    // Short URL: https://youtu.be/VIDEO_ID
    if (preg_match('/youtu\.be\/([^\&\?\/]+)/', $url, $matches)) {
        return 'https://www.youtube.com/embed/' . $matches[1] . '?rel=0';
    }
    
    // YouTube embed already
    if (preg_match('/youtube\.com\/embed\/([^\&\?\/]+)/', $url, $matches)) {
        return $url;
    }
    
    // Vimeo formats
    // Standard: https://vimeo.com/VIDEO_ID
    if (preg_match('/vimeo\.com\/(\d+)/', $url, $matches)) {
        return 'https://player.vimeo.com/video/' . $matches[1];
    }
    
    // Vimeo player already
    if (preg_match('/player\.vimeo\.com\/video\/(\d+)/', $url, $matches)) {
        return $url;
    }
    
    // If no pattern matches, return null
    return null;
}

// Also add this helper to get video platform
public function getVideoPlatform()
{
    if (!$this->hasVideo()) {
        return null;
    }
    
    if (strpos($this->video_url, 'youtube.com') !== false || strpos($this->video_url, 'youtu.be') !== false) {
        return 'YouTube';
    }
    
    if (strpos($this->video_url, 'vimeo.com') !== false) {
        return 'Vimeo';
    }
    
    return 'Other';
}
}