<?php

namespace App\Http\Controllers;

use App\Models\Saree;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display the specified saree product
     */
    public function show($slug)
    {
        // Fetch the saree with all necessary relationships
        $saree = Saree::with([
            'collection', 
            'images' => function($query) {
                $query->orderBy('sort_order');
            },
            'approvedReviews' => function($query) {
                $query->orderBy('created_at', 'desc');
            }
        ])
        ->where('slug', $slug)
        ->where('is_active', true)
        ->firstOrFail();

        // Increment view count (only once per session)
        if (!session()->has('viewed_saree_' . $saree->id)) {
            $saree->increment('views');
            session()->put('viewed_saree_' . $saree->id, true);
        }

        // Get related products from the same collection or similar attributes
        $relatedProducts = Saree::where('is_active', true)
            ->where('stock_quantity', '>', 0)
            ->where('id', '!=', $saree->id)
            ->where(function($query) use ($saree) {
                // Prioritize same collection
                if ($saree->collection_id) {
                    $query->where('collection_id', $saree->collection_id);
                }
                // Or same fabric
                if ($saree->fabric) {
                    $query->orWhere('fabric', $saree->fabric);
                }
                // Or same occasion
                if ($saree->occasion) {
                    $query->orWhere('occasion', $saree->occasion);
                }
            })
            ->with(['images'])
            ->limit(8)
            ->inRandomOrder()
            ->get();

        // If no related products found, get random sarees
        if ($relatedProducts->isEmpty()) {
            $relatedProducts = Saree::where('is_active', true)
                ->where('stock_quantity', '>', 0)
                ->where('id', '!=', $saree->id)
                ->with(['images'])
                ->inRandomOrder()
                ->limit(8)
                ->get();
        }

        // Get previous and next products for navigation
        $previousProduct = Saree::where('is_active', true)
            ->where('id', '<', $saree->id)
            ->orderBy('id', 'desc')
            ->first();

        $nextProduct = Saree::where('is_active', true)
            ->where('id', '>', $saree->id)
            ->orderBy('id', 'asc')
            ->first();

        // Parse colors array
        $colors = is_array($saree->colors) ? $saree->colors : [];

        return view('pages.shop-single-product', compact(
            'saree',
            'relatedProducts',
            'colors',
            'previousProduct',
            'nextProduct'
        ));
    }

    /**
     * Store a review for the product
     */
    public function storeReview(Request $request, $slug)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Please login to submit a review.');
        }

        $saree = Saree::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Validate the review data
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:1000',
        ], [
            'rating.required' => 'Please select a rating.',
            'rating.min' => 'Rating must be between 1 and 5 stars.',
            'rating.max' => 'Rating must be between 1 and 5 stars.',
            'comment.required' => 'Please write a review comment.',
            'comment.min' => 'Review must be at least 10 characters long.',
            'comment.max' => 'Review must not exceed 1000 characters.',
        ]);

        // Check if user already reviewed this product
        $existingReview = Review::where('saree_id', $saree->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingReview) {
            return redirect()->back()
                ->with('error', 'You have already reviewed this product.');
        }

        // Create the review
        Review::create([
            'saree_id' => $saree->id,
            'user_id' => Auth::id(),
            'name' => Auth::user()->name,
            'email' => Auth::user()->email,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'is_approved' => false, // Requires admin approval
        ]);

        return redirect()->back()
            ->with('success', 'Thank you for your review! It will be published after approval.');
    }
}