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

        // Increment view count
        $saree->increment('views');

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

        // Parse colors array
        $colors = is_array($saree->colors) ? $saree->colors : [];

        return view('pages.shop-single-product', compact(
            'saree',
            'relatedProducts',
            'colors'
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
        $review = Review::create([
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