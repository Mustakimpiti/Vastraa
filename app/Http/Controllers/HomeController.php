<?php

namespace App\Http\Controllers;

use App\Models\Saree;
use App\Models\Collection;
use App\Models\Blog;
use App\Models\Testimonial;
use App\Models\Video;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Fetch featured collections for the collection slider
        $featuredCollections = Collection::where('is_active', true)
            ->orderBy('sort_order')
            ->limit(3)
            ->get();

        // Fetch bestseller sarees for the Best Sellers section
        $bestSellers = Saree::where('is_active', true)
            ->where('stock_quantity', '>', 0)
            ->with(['collection', 'images'])
            ->orderBy('views', 'desc')
            ->limit(6)
            ->get();

        // If no bestsellers, get random active sarees
        if ($bestSellers->isEmpty()) {
            $bestSellers = Saree::where('is_active', true)
                ->where('stock_quantity', '>', 0)
                ->with(['collection', 'images'])
                ->inRandomOrder()
                ->limit(6)
                ->get();
        }

        // Fetch recent blog posts
        $recentBlogs = Blog::published()
            ->orderBy('published_at', 'desc')
            ->limit(2)
            ->get();

        // Fetch active testimonials (shop-wise reviews)
        $testimonials = Testimonial::active()
            ->ordered()
            ->limit(6)
            ->get();

        // Fetch active videos for trending section
        $trendingVideos = Video::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Single return statement with all variables
        return view('pages.home', compact(
            'featuredCollections',
            'bestSellers',
            'recentBlogs',
            'testimonials',
            'trendingVideos'
        ));
    }
}