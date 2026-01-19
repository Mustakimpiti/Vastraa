<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Saree;
use App\Models\SareeImage;
use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

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
$validated['slug'] = $this->generateUniqueSlug($validated['name']);

        // Ensure directories exist
        $this->ensureDirectoriesExist();

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $image = $request->file('featured_image');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/sarees'), $filename);
            $validated['featured_image'] = 'uploads/sarees/' . $filename;
        }

        $saree = Saree::create($validated);

        // Handle additional images
        if ($request->hasFile('additional_images')) {
            foreach ($request->file('additional_images') as $index => $image) {
                $filename = time() . '_' . uniqid() . '_' . $index . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/sarees/gallery'), $filename);
                
                SareeImage::create([
                    'saree_id' => $saree->id,
                    'image_path' => 'uploads/sarees/gallery/' . $filename,
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
$validated['slug'] = $this->generateUniqueSlug($validated['name'], $saree->id);

        // Ensure directories exist
        $this->ensureDirectoriesExist();

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image
            if ($saree->featured_image && file_exists(public_path($saree->featured_image))) {
                unlink(public_path($saree->featured_image));
            }
            
            $image = $request->file('featured_image');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/sarees'), $filename);
            $validated['featured_image'] = 'uploads/sarees/' . $filename;
        }

        $saree->update($validated);

        // Handle image removal
        if ($request->has('remove_images')) {
            foreach ($request->remove_images as $imageId) {
                $image = SareeImage::find($imageId);
                if ($image && $image->saree_id == $saree->id) {
                    if (file_exists(public_path($image->image_path))) {
                        unlink(public_path($image->image_path));
                    }
                    $image->delete();
                }
            }
        }

        // Handle new additional images
        if ($request->hasFile('additional_images')) {
            $currentMaxOrder = $saree->images()->max('sort_order') ?? 0;
            
            foreach ($request->file('additional_images') as $index => $image) {
                $filename = time() . '_' . uniqid() . '_' . $index . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/sarees/gallery'), $filename);
                
                SareeImage::create([
                    'saree_id' => $saree->id,
                    'image_path' => 'uploads/sarees/gallery/' . $filename,
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
        if ($saree->featured_image && file_exists(public_path($saree->featured_image))) {
            unlink(public_path($saree->featured_image));
        }

        // Delete all gallery images
        foreach ($saree->images as $image) {
            if (file_exists(public_path($image->image_path))) {
                unlink(public_path($image->image_path));
            }
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
        
        if (file_exists(public_path($image->image_path))) {
            unlink(public_path($image->image_path));
        }
        
        $image->delete();

        return response()->json(['success' => true]);
    }

    /**
     * Ensure upload directories exist
     */
    private function ensureDirectoriesExist()
    {
        $directories = [
            public_path('uploads'),
            public_path('uploads/sarees'),
            public_path('uploads/sarees/gallery'),
        ];

        foreach ($directories as $directory) {
            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0755, true);
            }
        }
    }
    private function generateUniqueSlug($name, $id = null)
{
    $slug = Str::slug($name);
    $originalSlug = $slug;
    $count = 1;

    while (true) {
        $query = Saree::where('slug', $slug);
        
        // Exclude current record when updating
        if ($id) {
            $query->where('id', '!=', $id);
        }
        
        if (!$query->exists()) {
            break;
        }
        
        $slug = $originalSlug . '-' . $count;
        $count++;
    }

    return $slug;
}
}