@extends('admin.layouts.app')

@section('title', 'Add New Saree')
@section('page-title', 'Add New Saree')

@section('content')
<div class="row">
    <div class="col-md-12">
        <a href="{{ route('admin.sarees.index') }}" class="btn btn-secondary mb-3">
            <i class="fa fa-arrow-left"></i> Back to List
        </a>
    </div>
</div>

<form action="{{ route('admin.sarees.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
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
                               value="{{ old('name') }}" 
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
                                       value="{{ old('sku') }}" 
                                       required>
                                <small class="text-muted">Unique product identifier</small>
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
                                       value="{{ old('fabric') }}" 
                                       placeholder="e.g., Silk, Cotton, Georgette"
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
                                  rows="2"
                                  placeholder="Brief description for product listing">{{ old('short_description') }}</textarea>
                        @error('short_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description" class="form-label">Full Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" 
                                  name="description" 
                                  rows="5"
                                  placeholder="Detailed product description">{{ old('description') }}</textarea>
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
                                       value="{{ old('length', 6.3) }}"
                                       placeholder="6.3">
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
                                       value="{{ old('blouse_length', 0.8) }}"
                                       placeholder="0.8">
                                @error('blouse_length')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Blouse Included</label>
                                <div class="form-check mt-2">
                                    <input class="form-check-input" 
                                           type="checkbox" 
                                           id="blouse_included" 
                                           name="blouse_included" 
                                           value="1" 
                                           {{ old('blouse_included') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="blouse_included">
                                        Yes, blouse piece included
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
                                       value="{{ old('work_type') }}" 
                                       placeholder="e.g., Embroidery, Zari, Handloom">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="occasion" class="form-label">Occasion</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="occasion" 
                                       name="occasion" 
                                       value="{{ old('occasion') }}" 
                                       placeholder="e.g., Wedding, Party, Casual">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="pattern" class="form-label">Pattern</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="pattern" 
                                       name="pattern" 
                                       value="{{ old('pattern') }}" 
                                       placeholder="e.g., Floral, Geometric, Plain">
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
                               value="{{ old('price') }}" 
                               placeholder="0.00"
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
                               value="{{ old('sale_price') }}"
                               placeholder="0.00">
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
                               value="{{ old('stock_quantity', 0) }}" 
                               placeholder="0"
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
                        <select class="form-control @error('collection_id') is-invalid @enderror" 
                                id="collection_id" 
                                name="collection_id">
                            <option value="">No Collection</option>
                            @foreach($collections as $collection)
                                <option value="{{ $collection->id }}" 
                                        {{ old('collection_id') == $collection->id ? 'selected' : '' }}>
                                    {{ $collection->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('collection_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Product Images -->
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Product Images</h5>
                </div>
                <div class="card-body">
                    <!-- Featured Image -->
                    <div class="form-group mb-4">
                        <label for="featured_image" class="form-label">
                            <strong>Featured Image (Main) *</strong>
                        </label>
                        <input type="file" 
                               class="form-control @error('featured_image') is-invalid @enderror" 
                               id="featured_image" 
                               name="featured_image" 
                               accept="image/jpeg,image/png,image/jpg,image/gif">
                        <small class="text-muted">This will be the main product image (Max: 2MB)</small>
                        @error('featured_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div id="featured-preview" class="mt-2"></div>
                    </div>

                    <hr>

                    <!-- Additional Images -->
                    <div class="form-group">
                        <label for="additional_images" class="form-label">
                            <strong>Additional Images (Gallery)</strong>
                        </label>
                        <input type="file" 
                               class="form-control @error('additional_images.*') is-invalid @enderror" 
                               id="additional_images" 
                               name="additional_images[]" 
                               accept="image/jpeg,image/png,image/jpg,image/gif"
                               multiple>
                        <small class="text-muted">Select multiple images (Hold Ctrl/Cmd). Max: 2MB each</small>
                        @error('additional_images.*')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div id="additional-preview" class="mt-3 row"></div>
                    </div>
                </div>
            </div>

            <!-- Status Flags -->
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Status & Badges</h5>
                </div>
                <div class="card-body">
                    <div class="form-check mb-2">
                        <input class="form-check-input" 
                               type="checkbox" 
                               id="is_active" 
                               name="is_active" 
                               value="1" 
                               {{ old('is_active', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">
                            <strong>Active</strong>
                            <small class="d-block text-muted">Visible on website</small>
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" 
                               type="checkbox" 
                               id="is_featured" 
                               name="is_featured" 
                               value="1" 
                               {{ old('is_featured') ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_featured">
                            <strong>Featured</strong>
                            <small class="d-block text-muted">Show in featured section</small>
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" 
                               type="checkbox" 
                               id="is_new_arrival" 
                               name="is_new_arrival" 
                               value="1" 
                               {{ old('is_new_arrival') ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_new_arrival">
                            <strong>New Arrival</strong>
                            <small class="d-block text-muted">Show "New" badge</small>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" 
                               type="checkbox" 
                               id="is_bestseller" 
                               name="is_bestseller" 
                               value="1" 
                               {{ old('is_bestseller') ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_bestseller">
                            <strong>Bestseller</strong>
                            <small class="d-block text-muted">Show "Bestseller" badge</small>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="card">
                <div class="card-body">
                    <button type="submit" class="btn btn-primary w-100 btn-lg">
                        <i class="fa fa-save"></i> Create Saree
                    </button>
                    <a href="{{ route('admin.sarees.index') }}" class="btn btn-secondary w-100 mt-2">
                        <i class="fa fa-times"></i> Cancel
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
    margin-bottom: 10px;
}
.image-preview-item img {
    max-height: 150px;
    width: 100%;
    object-fit: cover;
    border-radius: 4px;
    border: 2px solid #e0e0e0;
}
.remove-preview {
    position: absolute;
    top: 5px;
    right: 15px;
    background: #dc3545;
    color: white;
    border: none;
    border-radius: 50%;
    width: 25px;
    height: 25px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    line-height: 1;
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
}
.remove-preview:hover {
    background: #c82333;
}
.form-group {
    margin-bottom: 1rem;
}
</style>
@endpush

@push('scripts')
<script>
// Featured Image Preview
document.getElementById('featured_image').addEventListener('change', function(e) {
    const preview = document.getElementById('featured-preview');
    const file = e.target.files[0];
    
    if (file) {
        // Validate file size (2MB)
        if (file.size > 2048000) {
            alert('File size should not exceed 2MB');
            this.value = '';
            preview.innerHTML = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `
                <div class="image-preview-item">
                    <img src="${e.target.result}" class="img-fluid" alt="Featured image preview">
                    <small class="text-success d-block mt-1">
                        <i class="fa fa-check"></i> Image selected successfully
                    </small>
                </div>
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
    const files = Array.from(e.target.files);
    
    preview.innerHTML = '';
    
    if (files.length > 0) {
        // Validate file sizes
        const oversizedFiles = files.filter(file => file.size > 2048000);
        if (oversizedFiles.length > 0) {
            alert(`${oversizedFiles.length} file(s) exceed 2MB size limit`);
            this.value = '';
            return;
        }
        
        files.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const col = document.createElement('div');
                col.className = 'col-md-4 mb-2';
                col.innerHTML = `
                    <div class="image-preview-item">
                        <img src="${e.target.result}" class="img-fluid" alt="Gallery image ${index + 1}">
                        <span class="badge bg-primary position-absolute" style="top: 5px; left: 15px;">
                            ${index + 1}
                        </span>
                    </div>
                `;
                preview.appendChild(col);
            }
            reader.readAsDataURL(file);
        });
        
        // Add success message
        const successMsg = document.createElement('div');
        successMsg.className = 'col-12';
        successMsg.innerHTML = `
            <small class="text-success">
                <i class="fa fa-check"></i> ${files.length} image(s) selected successfully
            </small>
        `;
        preview.appendChild(successMsg);
    }
});

// Auto-generate SKU from name (optional)
document.getElementById('name').addEventListener('blur', function() {
    const skuField = document.getElementById('sku');
    if (!skuField.value) {
        const sku = this.value
            .toUpperCase()
            .replace(/[^A-Z0-9]/g, '')
            .substring(0, 8) + '-' + Math.floor(Math.random() * 1000);
        skuField.value = sku;
    }
});

// Validate sale price is less than regular price
document.getElementById('sale_price').addEventListener('blur', function() {
    const regularPrice = parseFloat(document.getElementById('price').value);
    const salePrice = parseFloat(this.value);
    
    if (salePrice && regularPrice && salePrice >= regularPrice) {
        alert('Sale price must be less than regular price');
        this.value = '';
    }
});
</script>
@endpush
@endsection