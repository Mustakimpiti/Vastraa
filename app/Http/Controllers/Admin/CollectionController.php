<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class CollectionController extends Controller
{
    public function index()
    {
        $collections = Collection::withCount('sarees')->latest()->paginate(15);
        return view('admin.collections.index', compact('collections'));
    }

    public function create()
    {
        return view('admin.collections.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:collections,name',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
            'launch_date' => 'nullable|date',
        ]);

        // Generate slug
        $validated['slug'] = Str::slug($validated['name']);

        // Ensure directories exist
        $this->ensureDirectoriesExist();

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/collections'), $filename);
            $validated['image'] = 'uploads/collections/' . $filename;
        }

        // Handle banner image upload
        if ($request->hasFile('banner_image')) {
            $image = $request->file('banner_image');
            $filename = 'banner_' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/collections'), $filename);
            $validated['banner_image'] = 'uploads/collections/' . $filename;
        }

        Collection::create($validated);

        return redirect()->route('admin.collections.index')
            ->with('success', 'Collection created successfully!');
    }

    public function show(Collection $collection)
    {
        $collection->load(['sarees' => function($query) {
            $query->latest()->take(10);
        }]);
        return view('admin.collections.show', compact('collection'));
    }

    public function edit(Collection $collection)
    {
        return view('admin.collections.edit', compact('collection'));
    }

    public function update(Request $request, Collection $collection)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:collections,name,' . $collection->id,
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
            'launch_date' => 'nullable|date',
        ]);

        // Update slug if name changed
        $validated['slug'] = Str::slug($validated['name']);

        // Ensure directories exist
        $this->ensureDirectoriesExist();

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($collection->image && file_exists(public_path($collection->image))) {
                unlink(public_path($collection->image));
            }
            
            $image = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/collections'), $filename);
            $validated['image'] = 'uploads/collections/' . $filename;
        }

        // Handle banner image upload
        if ($request->hasFile('banner_image')) {
            // Delete old banner
            if ($collection->banner_image && file_exists(public_path($collection->banner_image))) {
                unlink(public_path($collection->banner_image));
            }
            
            $image = $request->file('banner_image');
            $filename = 'banner_' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/collections'), $filename);
            $validated['banner_image'] = 'uploads/collections/' . $filename;
        }

        $collection->update($validated);

        return redirect()->route('admin.collections.index')
            ->with('success', 'Collection updated successfully!');
    }

    public function destroy(Collection $collection)
    {
        // Check if collection has sarees
        if ($collection->sarees()->count() > 0) {
            return redirect()->route('admin.collections.index')
                ->with('error', 'Cannot delete collection with associated sarees. Please reassign or delete the sarees first.');
        }

        // Delete images
        if ($collection->image && file_exists(public_path($collection->image))) {
            unlink(public_path($collection->image));
        }

        if ($collection->banner_image && file_exists(public_path($collection->banner_image))) {
            unlink(public_path($collection->banner_image));
        }

        $collection->delete();

        return redirect()->route('admin.collections.index')
            ->with('success', 'Collection deleted successfully!');
    }

    /**
     * Ensure upload directories exist
     */
    private function ensureDirectoriesExist()
    {
        $directories = [
            public_path('uploads'),
            public_path('uploads/collections'),
        ];

        foreach ($directories as $directory) {
            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0755, true);
            }
        }
    }
}