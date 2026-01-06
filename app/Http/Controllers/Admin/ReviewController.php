<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ReviewController extends Controller
{
    /**
     * Display a listing of reviews
     */
    public function index(Request $request)
    {
        $query = Review::with(['saree', 'user']);

        // Filter by approval status
        if ($request->has('status')) {
            if ($request->status === 'approved') {
                $query->where('is_approved', true);
            } elseif ($request->status === 'pending') {
                $query->where('is_approved', false);
            }
        }

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('comment', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('saree', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $reviews = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.reviews.index', compact('reviews'));
    }

    /**
     * Show a specific review
     */
    public function show($id)
    {
        $review = Review::with(['saree', 'user'])->findOrFail($id);
        return view('admin.reviews.index', compact('review'));
    }

    /**
     * Approve a review
     */
    public function approve($id)
    {
        $review = Review::findOrFail($id);
        $review->is_approved = true;
        $review->save();

        return redirect()->back()->with('success', 'Review approved successfully!');
    }

    /**
     * Reject/Unapprove a review
     */
    public function reject($id)
    {
        $review = Review::findOrFail($id);
        $review->is_approved = false;
        $review->save();

        return redirect()->back()->with('success', 'Review rejected successfully!');
    }

    /**
     * Delete a review
     */
    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        
        // Delete review images if they exist
        if (!empty($review->images)) {
            foreach ($review->images as $imagePath) {
                if (file_exists(public_path($imagePath))) {
                    unlink(public_path($imagePath));
                }
            }
        }
        
        $review->delete();

        return redirect()->back()->with('success', 'Review deleted successfully!');
    }

    /**
     * Bulk delete reviews
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'review_ids' => 'required|array',
            'review_ids.*' => 'exists:reviews,id'
        ]);

        $reviews = Review::whereIn('id', $request->review_ids)->get();
        
        foreach ($reviews as $review) {
            // Delete review images if they exist
            if (!empty($review->images)) {
                foreach ($review->images as $imagePath) {
                    if (file_exists(public_path($imagePath))) {
                        unlink(public_path($imagePath));
                    }
                }
            }
            $review->delete();
        }

        return response()->json([
            'success' => true,
            'message' => count($request->review_ids) . ' review(s) deleted successfully!'
        ]);
    }

    /**
     * Quick approve from notification/anywhere
     */
    public function quickApprove(Request $request)
    {
        $request->validate([
            'review_ids' => 'required|array',
            'review_ids.*' => 'exists:reviews,id'
        ]);

        $reviewIds = $request->input('review_ids', []);
        
        Review::whereIn('id', $reviewIds)->update(['is_approved' => true]);

        return response()->json([
            'success' => true,
            'message' => count($reviewIds) . ' review(s) approved successfully!'
        ]);
    }

    /**
     * Bulk approve reviews
     */
    public function bulkApprove(Request $request)
    {
        $request->validate([
            'review_ids' => 'required|array',
            'review_ids.*' => 'exists:reviews,id'
        ]);

        Review::whereIn('id', $request->review_ids)->update(['is_approved' => true]);

        return response()->json([
            'success' => true,
            'message' => count($request->review_ids) . ' review(s) approved successfully!'
        ]);
    }

    /**
     * Bulk reject reviews
     */
    public function bulkReject(Request $request)
    {
        $request->validate([
            'review_ids' => 'required|array',
            'review_ids.*' => 'exists:reviews,id'
        ]);

        Review::whereIn('id', $request->review_ids)->update(['is_approved' => false]);

        return response()->json([
            'success' => true,
            'message' => count($request->review_ids) . ' review(s) rejected successfully!'
        ]);
    }

    /**
     * Get pending reviews count
     */
    public function getPendingCount()
    {
        $count = Review::where('is_approved', false)->count();
        
        return response()->json([
            'count' => $count
        ]);
    }
}