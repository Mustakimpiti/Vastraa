<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'excerpt', 'content', 'featured_image',
        'author_name', 'author_image', 'views', 'is_featured',
        'is_published', 'published_at', 'meta_title',
        'meta_description', 'meta_keywords'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'views' => 'integer',
    ];

    /**
     * Boot method to auto-generate slug and set published date
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($blog) {
            if (!$blog->slug) {
                $blog->slug = Str::slug($blog->title);
            }
            if (!$blog->published_at && $blog->is_published) {
                $blog->published_at = now();
            }
        });

        static::updating(function ($blog) {
            // Auto-update slug if title changes
            if ($blog->isDirty('title')) {
                $blog->slug = Str::slug($blog->title);
            }
            // Set published date if publishing for the first time
            if ($blog->isDirty('is_published') && $blog->is_published && !$blog->published_at) {
                $blog->published_at = now();
            }
        });
    }

    /**
     * REMOVED getRouteKeyName() - Let Laravel use ID by default for admin routes
     * Frontend routes will explicitly use 'slug' parameter
     */

    /**
     * Increment blog views
     */
    public function incrementViews()
    {
        $this->increment('views');
    }

    /**
     * Calculate reading time based on content
     */
    public function getReadingTimeAttribute()
    {
        $wordCount = str_word_count(strip_tags($this->content));
        $minutes = ceil($wordCount / 200); // Average reading speed: 200 words/minute
        return $minutes . ' min read';
    }

    /**
     * Get formatted published date
     */
    public function getFormattedDateAttribute()
    {
        return $this->published_at 
            ? $this->published_at->format('M d, Y') 
            : $this->created_at->format('M d, Y');
    }

    /**
     * Get short excerpt with limit
     */
    public function getShortExcerptAttribute()
    {
        if ($this->excerpt) {
            return Str::limit($this->excerpt, 150);
        }
        return Str::limit(strip_tags($this->content), 150);
    }

    /**
     * Scope: Get only published blogs
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now());
    }

    /**
     * Scope: Get only featured blogs
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope: Get recent blogs
     */
    public function scopeRecent($query, $limit = 5)
    {
        return $query->orderBy('published_at', 'desc')->limit($limit);
    }

    /**
     * Scope: Search blogs by title, content, or excerpt
     */
    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('author_name', 'like', "%{$search}%");
            });
        }
        return $query;
    }
}