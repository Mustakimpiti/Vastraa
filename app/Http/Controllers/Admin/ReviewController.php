<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of reviews
     */
    public function index()
    {
        $reviews = Review::with(['saree', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.reviews.index', compact('reviews'));
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
        $review->delete();

        return redirect()->back()->with('success', 'Review deleted successfully!');
    }

    /**
     * Quick approve from notification/anywhere
     */
    public function quickApprove(Request $request)
    {
        $reviewIds = $request->input('review_ids', []);
        
        Review::whereIn('id', $reviewIds)->update(['is_approved' => true]);

        return response()->json([
            'success' => true,
            'message' => count($reviewIds) . ' review(s) approved successfully!'
        ]);
    }
}