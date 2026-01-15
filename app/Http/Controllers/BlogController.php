<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of blog posts
     */
    public function index(Request $request)
    {
        $query = Blog::published();

        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->search($request->search);
        }

        // Paginate results
        $blogs = $query->orderBy('published_at', 'desc')->paginate(9);
        
        // Get featured blogs (only if not searching)
        $featuredBlogs = collect();
        if (!$request->has('search')) {
            $featuredBlogs = Blog::published()
                ->featured()
                ->recent(3)
                ->get();
        }

        return view('pages.blogs', compact('blogs', 'featuredBlogs'));
    }

    /**
     * Display the specified blog post by slug
     */
    public function show($slug)
    {
        // Get the blog post by slug (frontend uses slug)
        $blog = Blog::where('slug', $slug)
            ->published()
            ->firstOrFail();
        
        // Increment views (only once per session)
        if (!session()->has('blog_viewed_' . $blog->id)) {
            $blog->incrementViews();
            session()->put('blog_viewed_' . $blog->id, true);
        }

        // Get related blogs (random, excluding current)
        $relatedBlogs = Blog::published()
            ->where('id', '!=', $blog->id)
            ->inRandomOrder()
            ->limit(3)
            ->get();

        // Get recent blogs for sidebar
        $recentBlogs = Blog::published()
            ->where('id', '!=', $blog->id)
            ->recent(5)
            ->get();

        return view('pages.blog-single', compact('blog', 'relatedBlogs', 'recentBlogs'));
    }
}