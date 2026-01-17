@extends('admin.layouts.app')

@section('title', 'Edit Saree')
@section('page-title', 'Edit Saree')

@section('content')
<div class="row">
    <div class="col-md-12">
        <a href="{{ route('admin.sarees.index') }}" class="btn btn-secondary mb-3">
            <i class="fa fa-arrow-left"></i> Back to List
        </a>
    </div>
</div>

<form action="{{ route('admin.sarees.update', $saree) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    <div class="row">
        <!-- Main Information -->
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Basic Information</h5>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="name" class="form-label">Saree Name *</label>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $saree->name) }}" 
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="sku" class="form-label">SKU *</label>
                                <input type="text" 
                                       class="form-control @error('sku') is-invalid @enderror" 
                                       id="sku" 
                                       name="sku" 
                                       value="{{ old('sku', $saree->sku) }}" 
                                       required>
                                @error('sku')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fabric" class="form-label">Fabric *</label>
                                <input type="text" 
                                       class="form-control @error('fabric') is-invalid @enderror" 
                                       id="fabric" 
                                       name="fabric" 
                                       value="{{ old('fabric', $saree->fabric) }}" 
                                       required>
                                @error('fabric')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="short_description" class="form-label">Short Description</label>
                        <textarea class="form-control @error('short_description') is-invalid @enderror" 
                                  id="short_description" 
                                  name="short_description" 
                                  rows="2">{{ old('short_description', $saree->short_description) }}</textarea>
                        @error('short_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description" class="form-label">Full Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" 
                                  name="description" 
                                  rows="5">{{ old('description', $saree->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Saree Details -->
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Saree Details</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="length" class="form-label">Length (meters)</label>
                                <input type="number" 
                                       step="0.1" 
                                       class="form-control @error('length') is-invalid @enderror" 
                                       id="length" 
                                       name="length" 
                                       value="{{ old('length', $saree->length) }}">
                                @error('length')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="blouse_length" class="form-label">Blouse Length (meters)</label>
                                <input type="number" 
                                       step="0.1" 
                                       class="form-control @error('blouse_length') is-invalid @enderror" 
                                       id="blouse_length" 
                                       name="blouse_length" 
                                       value="{{ old('blouse_length', $saree->blouse_length) }}">
                                @error('blouse_length')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Blouse Included</label>
                                <div class="form-check">
                                    <input class="form-check-input" 
                                           type="checkbox" 
                                           id="blouse_included" 
                                           name="blouse_included" 
                                           value="1" 
                                           {{ old('blouse_included', $saree->blouse_included) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="blouse_included">
                                        Yes
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="work_type" class="form-label">Work Type</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="work_type" 
                                       name="work_type" 
                                       value="{{ old('work_type', $saree->work_type) }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="occasion" class="form-label">Occasion</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="occasion" 
                                       name="occasion" 
                                       value="{{ old('occasion', $saree->occasion) }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="pattern" class="form-label">Pattern</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="pattern" 
                                       name="pattern" 
                                       value="{{ old('pattern', $saree->pattern) }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-md-4">
            <!-- Pricing & Stock -->
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Pricing & Stock</h5>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="price" class="form-label">Regular Price (₹) *</label>
                        <input type="number" 
                               step="0.01" 
                               class="form-control @error('price') is-invalid @enderror" 
                               id="price" 
                               name="price" 
                               value="{{ old('price', $saree->price) }}" 
                               required>
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="sale_price" class="form-label">Sale Price (₹)</label>
                        <input type="number" 
                               step="0.01" 
                               class="form-control @error('sale_price') is-invalid @enderror" 
                               id="sale_price" 
                               name="sale_price" 
                               value="{{ old('sale_price', $saree->sale_price) }}">
                        <small class="text-muted">Leave empty if no discount</small>
                        @error('sale_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="stock_quantity" class="form-label">Stock Quantity *</label>
                        <input type="number" 
                               class="form-control @error('stock_quantity') is-invalid @enderror" 
                               id="stock_quantity" 
                               name="stock_quantity" 
                               value="{{ old('stock_quantity', $saree->stock_quantity) }}" 
                               required>
                        @error('stock_quantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Collection -->
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Collection</h5>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="collection_id" class="form-label">Select Collection</label>
                        <select class="form-control" id="collection_id" name="collection_id">
                            <option value="">No Collection</option>
                            @foreach($collections as $collection)
                                <option value="{{ $collection->id }}" 
                                        {{ old('collection_id', $saree->collection_id) == $collection->id ? 'selected' : '' }}>
                                    {{ $collection->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
<div class="card mb-4">
    <div class="card-header bg-white">
        <h5 class="mb-0">Product Images</h5>
    </div>
    <div class="card-body">
    <!-- Featured Image -->
<div class="form-group mb-4">
    <label class="form-label">
        <strong>Featured Image (Main)</strong>
    </label>
    @if($saree->featured_image)
        <div class="mb-3">
            <img src="{{ asset($saree->featured_image) }}" 
                 class="img-fluid" 
                 style="max-height: 200px; border-radius: 4px; border: 2px solid #e0e0e0;">
            <p class="text-muted mt-2 mb-0 small">Current featured image</p>
        </div>
    @endif
    <input type="file" 
           class="form-control @error('featured_image') is-invalid @enderror" 
           id="featured_image" 
           name="featured_image" 
           accept="image/*">
    <small class="text-muted">Upload new image to replace current one</small>
    @error('featured_image')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    <div id="featured-preview" class="mt-2"></div>
</div>

        <hr>

<!-- Existing Gallery Images -->
@if($saree->images && $saree->images->count() > 0)
<div class="form-group mb-4">
    <label class="form-label">
        <strong>Current Gallery Images</strong>
    </label>
    <div class="row">
        @foreach($saree->images as $image)
        <div class="col-md-4 mb-3" id="image-{{ $image->id }}">
            <div class="position-relative">
                <img src="{{ asset($image->image_path) }}" 
                     class="img-fluid" 
                     style="max-height: 150px; border-radius: 4px; border: 2px solid #e0e0e0;">
                <button type="button" 
                        class="btn btn-danger btn-sm position-absolute remove-existing-image"
                        style="top: 5px; right: 5px;"
                        data-image-id="{{ $image->id }}"
                        onclick="removeExistingImage({{ $image->id }})">
                    <i class="fa fa-trash"></i>
                </button>
                <span class="badge bg-secondary position-absolute" style="bottom: 5px; left: 5px;">
                    {{ $image->sort_order }}
                </span>
            </div>
        </div>
        @endforeach
    </div>
    <input type="hidden" name="remove_images[]" id="remove_images" value="">
</div>
<hr>
@endif

        <!-- Add New Images -->
        <div class="form-group">
            <label for="additional_images" class="form-label">
                <strong>Add New Gallery Images</strong>
            </label>
            <input type="file" 
                   class="form-control @error('additional_images.*') is-invalid @enderror" 
                   id="additional_images" 
                   name="additional_images[]" 
                   accept="image/*"
                   multiple>
            <small class="text-muted">Select multiple images to add to gallery</small>
            @error('additional_images.*')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div id="additional-preview" class="mt-3 row"></div>
        </div>
    </div>
</div>
<!-- Video Section -->
<div class="card mb-4">
    <div class="card-header bg-white">
        <h5 class="mb-0">Product Video (Optional)</h5>
    </div>
    <div class="card-body">
        <div class="form-group">
            <label for="video_url" class="form-label">Video URL</label>
            <input type="url" 
                   class="form-control @error('video_url') is-invalid @enderror" 
                   id="video_url" 
                   name="video_url" 
                   value="{{ old('video_url', $saree->video_url) }}"
                   placeholder="https://www.youtube.com/watch?v=...">
            <small class="text-muted">
                Paste YouTube or Vimeo URL
            </small>
            @error('video_url')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        @if($saree->video_url)
        <div class="mt-3 p-3 bg-light rounded">
            <p class="mb-2"><strong>Current Video Link:</strong></p>
            <div class="d-flex align-items-center justify-content-between">
                <small class="text-muted text-truncate me-2" style="max-width: 70%;">
                    {{ $saree->video_url }}
                </small>
                <a href="{{ $saree->video_url }}" 
                   target="_blank" 
                   rel="noopener noreferrer"
                   class="btn btn-sm btn-danger">
                    <i class="fa fa-play"></i> Watch
                </a>
            </div>
        </div>
        @endif
    </div>
</div>

            <!-- Status Flags -->
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Status</h5>
                </div>
                <div class="card-body">
                    <div class="form-check mb-2">
                        <input class="form-check-input" 
                               type="checkbox" 
                               id="is_active" 
                               name="is_active" 
                               value="1" 
                               {{ old('is_active', $saree->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">
                            Active
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" 
                               type="checkbox" 
                               id="is_featured" 
                               name="is_featured" 
                               value="1" 
                               {{ old('is_featured', $saree->is_featured) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_featured">
                            Featured
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" 
                               type="checkbox" 
                               id="is_new_arrival" 
                               name="is_new_arrival" 
                               value="1" 
                               {{ old('is_new_arrival', $saree->is_new_arrival) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_new_arrival">
                            New Arrival
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" 
                               type="checkbox" 
                               id="is_bestseller" 
                               name="is_bestseller" 
                               value="1" 
                               {{ old('is_bestseller', $saree->is_bestseller) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_bestseller">
                            Bestseller
                        </label>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="card">
                <div class="card-body">
                    <button type="submit" class="btn btn-primary w-100 mb-2">
                        <i class="fa fa-save"></i> Update Saree
                    </button>
                    <a href="{{ route('admin.sarees.show', $saree) }}" class="btn btn-info w-100">
                        <i class="fa fa-eye"></i> View Details
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>

@push('styles')
<style>
.image-preview-item {
    position: relative;
}
.image-preview-item img {
    max-height: 150px;
    border-radius: 4px;
    border: 2px solid #e0e0e0;
}
</style>
@endpush

@push('scripts')
@push('scripts')
<script>
let imagesToRemove = [];

// Remove existing image
function removeExistingImage(imageId) {
    if (confirm('Are you sure you want to remove this image?')) {
        imagesToRemove.push(imageId);
        document.getElementById('remove_images').value = imagesToRemove.join(',');
        document.getElementById('image-' + imageId).style.display = 'none';
    }
}

// Featured Image Preview
document.getElementById('featured_image').addEventListener('change', function(e) {
    const preview = document.getElementById('featured-preview');
    const file = e.target.files[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `
                <p class="text-muted mt-2 mb-1 small">New featured image preview:</p>
                <img src="${e.target.result}" class="img-fluid" style="max-height: 200px; border-radius: 4px; border: 2px solid #28a745;">
            `;
        }
        reader.readAsDataURL(file);
    } else {
        preview.innerHTML = '';
    }
});

// Additional Images Preview
document.getElementById('additional_images').addEventListener('change', function(e) {
    const preview = document.getElementById('additional-preview');
    const files = e.target.files;
    
    preview.innerHTML = '';
    
    if (files.length > 0) {
        Array.from(files).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const col = document.createElement('div');
                col.className = 'col-md-4 mb-3';
                col.innerHTML = `
                    <div class="image-preview-item">
                        <img src="${e.target.result}" class="img-fluid">
                        <span class="badge bg-success position-absolute" style="top: 5px; left: 5px;">
                            New ${index + 1}
                        </span>
                    </div>
                `;
                preview.appendChild(col);
            }
            reader.readAsDataURL(file);
        });
    }
});

// Update form to handle array of images to remove
document.querySelector('form').addEventListener('submit', function(e) {
    if (imagesToRemove.length > 0) {
        // Remove the single hidden input
        const oldInput = document.getElementById('remove_images');
        if (oldInput) oldInput.remove();
        
        // Add multiple hidden inputs for each image to remove
        imagesToRemove.forEach(function(imageId) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'remove_images[]';
            input.value = imageId;
            document.querySelector('form').appendChild(input);
        });
    }
});
</script>
@endpush
@endpush
@endsection