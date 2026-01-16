<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        return view('admin.Testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        return view('admin.Testimonials.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_location' => 'nullable|string|max:255',
            'customer_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'testimonial' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        // Handle image upload
        if ($request->hasFile('customer_image')) {
            $image = $request->file('customer_image');
            $imageName = 'testimonial_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/img/testimonial'), $imageName);
            $validated['customer_image'] = 'assets/img/testimonial/' . $imageName;
        }

        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_active'] = $request->has('is_active');

        Testimonial::create($validated);

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimonial created successfully.');
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.Testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_location' => 'nullable|string|max:255',
            'customer_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'testimonial' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        // Handle image upload
        if ($request->hasFile('customer_image')) {
            // Delete old image if exists
            if ($testimonial->customer_image && file_exists(public_path($testimonial->customer_image))) {
                unlink(public_path($testimonial->customer_image));
            }

            $image = $request->file('customer_image');
            $imageName = 'testimonial_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/img/testimonial'), $imageName);
            $validated['customer_image'] = 'assets/img/testimonial/' . $imageName;
        }

        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_active'] = $request->has('is_active');

        $testimonial->update($validated);

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimonial updated successfully.');
    }

    public function destroy(Testimonial $testimonial)
    {
        // Delete image if exists
        if ($testimonial->customer_image && file_exists(public_path($testimonial->customer_image))) {
            unlink(public_path($testimonial->customer_image));
        }

        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimonial deleted successfully.');
    }

    public function toggleFeatured(Testimonial $testimonial)
    {
        $testimonial->update(['is_featured' => !$testimonial->is_featured]);
        
        return response()->json([
            'success' => true,
            'is_featured' => $testimonial->is_featured
        ]);
    }

    public function toggleActive(Testimonial $testimonial)
    {
        $testimonial->update(['is_active' => !$testimonial->is_active]);
        
        return response()->json([
            'success' => true,
            'is_active' => $testimonial->is_active
        ]);
    }
}