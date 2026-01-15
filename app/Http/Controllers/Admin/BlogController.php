<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Blog::query();

        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->search($request->search);
        }

        // Filter by status
        if ($request->has('status')) {
            if ($request->status == 'published') {
                $query->where('is_published', true);
            } elseif ($request->status == 'draft') {
                $query->where('is_published', false);
            } elseif ($request->status == 'featured') {
                $query->where('is_featured', true);
            }
        }

        $blogs = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.blogs.index', compact('blogs'));
    }

    public function create()
    {
        return view('admin.blogs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'author_name' => 'required|string|max:255',
            'author_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:1024',
            'published_at' => 'nullable|date',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
        ]);

        // Handle checkboxes (they won't be in request if unchecked)
        $validated['is_featured'] = $request->has('is_featured') ? true : false;
        $validated['is_published'] = $request->has('is_published') ? true : false;

        // Auto-generate slug from title
        $validated['slug'] = Str::slug($validated['title']);
        
        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $image = $request->file('featured_image');
            $filename = time() . '_' . Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/blogs'), $filename);
            $validated['featured_image'] = 'uploads/blogs/' . $filename;
        }

        // Handle author image upload
        if ($request->hasFile('author_image')) {
            $image = $request->file('author_image');
            $filename = 'author_' . time() . '_' . Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/blogs/authors'), $filename);
            $validated['author_image'] = 'uploads/blogs/authors/' . $filename;
        }

        // Set published_at if publishing and not already set
        if ($validated['is_published'] && !isset($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        Blog::create($validated);

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post created successfully!');
    }

    public function edit(Blog $blog)
    {
        return view('admin.blogs.edit', compact('blog'));
    }

    public function update(Request $request, Blog $blog)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'author_name' => 'required|string|max:255',
            'author_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:1024',
            'published_at' => 'nullable|date',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
        ]);

        // Handle checkboxes
        $validated['is_featured'] = $request->has('is_featured') ? true : false;
        $validated['is_published'] = $request->has('is_published') ? true : false;

        // Auto-generate slug from title
        $validated['slug'] = Str::slug($validated['title']);

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image if exists
            if ($blog->featured_image && file_exists(public_path($blog->featured_image))) {
                unlink(public_path($blog->featured_image));
            }
            
            $image = $request->file('featured_image');
            $filename = time() . '_' . Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/blogs'), $filename);
            $validated['featured_image'] = 'uploads/blogs/' . $filename;
        }

        // Handle author image upload
        if ($request->hasFile('author_image')) {
            // Delete old image if exists
            if ($blog->author_image && file_exists(public_path($blog->author_image))) {
                unlink(public_path($blog->author_image));
            }
            
            $image = $request->file('author_image');
            $filename = 'author_' . time() . '_' . Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/blogs/authors'), $filename);
            $validated['author_image'] = 'uploads/blogs/authors/' . $filename;
        }

        // Set published_at if publishing for the first time
        if ($validated['is_published'] && !$blog->published_at && !isset($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        $blog->update($validated);

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post updated successfully!');
    }

    public function destroy(Blog $blog)
    {
        // Delete featured image if exists
        if ($blog->featured_image && file_exists(public_path($blog->featured_image))) {
            unlink(public_path($blog->featured_image));
        }
        
        // Delete author image if exists
        if ($blog->author_image && file_exists(public_path($blog->author_image))) {
            unlink(public_path($blog->author_image));
        }

        $blog->delete();

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post deleted successfully!');
    }

    /**
     * Quick toggle featured status
     */
    public function toggleFeatured(Blog $blog)
    {
        $blog->update(['is_featured' => !$blog->is_featured]);
        
        return response()->json([
            'success' => true,
            'is_featured' => $blog->is_featured
        ]);
    }

    /**
     * Quick toggle published status
     */
    public function togglePublished(Blog $blog)
    {
        $newStatus = !$blog->is_published;
        
        $blog->update([
            'is_published' => $newStatus,
            'published_at' => $newStatus && !$blog->published_at ? now() : $blog->published_at
        ]);
        
        return response()->json([
            'success' => true,
            'is_published' => $blog->is_published
        ]);
    }
}