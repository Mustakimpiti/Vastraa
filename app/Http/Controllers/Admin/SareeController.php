<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Saree;
use App\Models\SareeImage;
use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class SareeController extends Controller
{
    public function index()
    {
        $sarees = Saree::with('collection')->latest()->paginate(15);
        return view('admin.sarees.index', compact('sarees'));
    }

    public function create()
    {
        $collections = Collection::where('is_active', true)->get();
        return view('admin.sarees.create', compact('collections'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:sarees,sku',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string',
            'fabric' => 'required|string',
            'length' => 'nullable|numeric',
            'blouse_length' => 'nullable|numeric',
            'work_type' => 'nullable|string',
            'occasion' => 'nullable|string',
            'pattern' => 'nullable|string',
            'blouse_included' => 'boolean',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'collection_id' => 'nullable|exists:collections,id',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_featured' => 'boolean',
            'is_new_arrival' => 'boolean',
            'is_bestseller' => 'boolean',
            'is_active' => 'boolean',
            'colors' => 'nullable|array',
            'care_instructions' => 'nullable|array',
        ]);

        // Generate slug
        $validated['slug'] = Str::slug($validated['name']);

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('sarees', 'public');
            $validated['featured_image'] = $path;
        }

        $saree = Saree::create($validated);

        // Handle additional images
        if ($request->hasFile('additional_images')) {
            foreach ($request->file('additional_images') as $index => $image) {
                $path = $image->store('sarees/gallery', 'public');
                
                SareeImage::create([
                    'saree_id' => $saree->id,
                    'image_path' => $path,
                    'is_primary' => false,
                    'sort_order' => $index + 1
                ]);
            }
        }

        return redirect()->route('admin.sarees.index')
            ->with('success', 'Saree created successfully!');
    }

    public function show(Saree $saree)
    {
        $saree->load('collection', 'images');
        return view('admin.sarees.show', compact('saree'));
    }

    public function edit(Saree $saree)
    {
        $collections = Collection::where('is_active', true)->get();
        $saree->load('images');
        return view('admin.sarees.edit', compact('saree', 'collections'));
    }

    public function update(Request $request, Saree $saree)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:sarees,sku,' . $saree->id,
            'description' => 'nullable|string',
            'short_description' => 'nullable|string',
            'fabric' => 'required|string',
            'length' => 'nullable|numeric',
            'blouse_length' => 'nullable|numeric',
            'work_type' => 'nullable|string',
            'occasion' => 'nullable|string',
            'pattern' => 'nullable|string',
            'blouse_included' => 'boolean',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'collection_id' => 'nullable|exists:collections,id',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_featured' => 'boolean',
            'is_new_arrival' => 'boolean',
            'is_bestseller' => 'boolean',
            'is_active' => 'boolean',
            'colors' => 'nullable|array',
            'care_instructions' => 'nullable|array',
            'remove_images' => 'nullable|array',
        ]);

        // Update slug if name changed
        $validated['slug'] = Str::slug($validated['name']);

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image
            if ($saree->featured_image) {
                Storage::disk('public')->delete($saree->featured_image);
            }
            $path = $request->file('featured_image')->store('sarees', 'public');
            $validated['featured_image'] = $path;
        }

        $saree->update($validated);

        // Handle image removal
        if ($request->has('remove_images')) {
            foreach ($request->remove_images as $imageId) {
                $image = SareeImage::find($imageId);
                if ($image && $image->saree_id == $saree->id) {
                    Storage::disk('public')->delete($image->image_path);
                    $image->delete();
                }
            }
        }

        // Handle new additional images
        if ($request->hasFile('additional_images')) {
            $currentMaxOrder = $saree->images()->max('sort_order') ?? 0;
            
            foreach ($request->file('additional_images') as $index => $image) {
                $path = $image->store('sarees/gallery', 'public');
                
                SareeImage::create([
                    'saree_id' => $saree->id,
                    'image_path' => $path,
                    'is_primary' => false,
                    'sort_order' => $currentMaxOrder + $index + 1
                ]);
            }
        }

        return redirect()->route('admin.sarees.index')
            ->with('success', 'Saree updated successfully!');
    }

    public function destroy(Saree $saree)
    {
        // Delete featured image
        if ($saree->featured_image) {
            Storage::disk('public')->delete($saree->featured_image);
        }

        // Delete all gallery images
        foreach ($saree->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        $saree->delete();

        return redirect()->route('admin.sarees.index')
            ->with('success', 'Saree deleted successfully!');
    }

    /**
     * Delete a single gallery image
     */
    public function deleteImage($id)
    {
        $image = SareeImage::findOrFail($id);
        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return response()->json(['success' => true]);
    }
}