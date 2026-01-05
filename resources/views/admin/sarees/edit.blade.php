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

            <!-- Featured Image -->
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Featured Image</h5>
                </div>
                <div class="card-body">
                    @if($saree->featured_image)
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $saree->featured_image) }}" 
                                 class="img-fluid" 
                                 style="max-height: 200px;">
                            <p class="text-muted mt-2 mb-0">Current Image</p>
                        </div>
                    @endif
                    <div class="form-group">
                        <input type="file" 
                               class="form-control @error('featured_image') is-invalid @enderror" 
                               id="featured_image" 
                               name="featured_image" 
                               accept="image/*">
                        <small class="text-muted">Leave empty to keep current image</small>
                        @error('featured_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div id="image-preview" class="mt-2"></div>
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

@push('scripts')
<script>
    // Image preview
    document.getElementById('featured_image').addEventListener('change', function(e) {
        const preview = document.getElementById('image-preview');
        const file = e.target.files[0];
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = `<p class="text-muted mt-2 mb-1">New Image Preview:</p><img src="${e.target.result}" class="img-fluid" style="max-height: 200px;">`;
            }
            reader.readAsDataURL(file);
        } else {
            preview.innerHTML = '';
        }
    });
</script>
@endpush
@endsection