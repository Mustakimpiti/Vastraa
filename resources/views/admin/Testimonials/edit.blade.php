@extends('admin.layouts.app')

@section('title', 'Edit Testimonial')
@section('page-title', 'Edit Testimonial')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Edit Testimonial Information</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.testimonials.update', $testimonial->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Customer Name -->
                    <div class="form-group">
                        <label for="customer_name" class="form-label">Customer Name <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('customer_name') is-invalid @enderror" 
                               id="customer_name" 
                               name="customer_name" 
                               value="{{ old('customer_name', $testimonial->customer_name) }}" 
                               required>
                        @error('customer_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Customer Location -->
                    <div class="form-group">
                        <label for="customer_location" class="form-label">Customer Location</label>
                        <input type="text" 
                               class="form-control @error('customer_location') is-invalid @enderror" 
                               id="customer_location" 
                               name="customer_location" 
                               value="{{ old('customer_location', $testimonial->customer_location) }}" 
                               placeholder="e.g., Mumbai, India">
                        @error('customer_location')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Current Image Display -->
                    @if($testimonial->customer_image)
                    <div class="form-group">
                        <label class="form-label">Current Image</label>
                        <div class="mb-2">
                            <img src="{{ asset($testimonial->customer_image) }}" 
                                 alt="{{ $testimonial->customer_name }}" 
                                 class="img-thumbnail"
                                 style="max-width: 200px; max-height: 200px;">
                        </div>
                    </div>
                    @endif

                    <!-- Customer Image -->
                    <div class="form-group">
                        <label for="customer_image" class="form-label">
                            {{ $testimonial->customer_image ? 'Change Customer Image' : 'Customer Image' }}
                        </label>
                        <input type="file" 
                               class="form-control @error('customer_image') is-invalid @enderror" 
                               id="customer_image" 
                               name="customer_image" 
                               accept="image/*"
                               onchange="previewImage(event)">
                        <small class="text-muted">Recommended: Square image (e.g., 300x300px). Leave empty to keep current image.</small>
                        @error('customer_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        
                        <!-- Image Preview -->
                        <div id="imagePreview" class="mt-3" style="display: none;">
                            <label class="form-label">New Image Preview:</label>
                            <img id="preview" src="" alt="Preview" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                        </div>
                    </div>

                    <!-- Testimonial -->
                    <div class="form-group">
                        <label for="testimonial" class="form-label">Testimonial <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('testimonial') is-invalid @enderror" 
                                  id="testimonial" 
                                  name="testimonial" 
                                  rows="5" 
                                  required>{{ old('testimonial', $testimonial->testimonial) }}</textarea>
                        <small class="text-muted">Share the customer's feedback and experience</small>
                        @error('testimonial')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Rating -->
                    <div class="form-group">
                        <label for="rating" class="form-label">Rating <span class="text-danger">*</span></label>
                        <select class="form-control @error('rating') is-invalid @enderror" 
                                id="rating" 
                                name="rating" 
                                required>
                            <option value="">Select Rating</option>
                            @for($i = 5; $i >= 1; $i--)
                                <option value="{{ $i }}" {{ old('rating', $testimonial->rating) == $i ? 'selected' : '' }}>
                                    {{ $i }} Star{{ $i > 1 ? 's' : '' }}
                                </option>
                            @endfor
                        </select>
                        @error('rating')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Sort Order -->
                    <div class="form-group">
                        <label for="sort_order" class="form-label">Sort Order</label>
                        <input type="number" 
                               class="form-control @error('sort_order') is-invalid @enderror" 
                               id="sort_order" 
                               name="sort_order" 
                               value="{{ old('sort_order', $testimonial->sort_order ?? 0) }}" 
                               min="0">
                        <small class="text-muted">Lower numbers appear first</small>
                        @error('sort_order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Status Checkboxes -->
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="is_featured" 
                                   name="is_featured" 
                                   value="1"
                                   {{ old('is_featured', $testimonial->is_featured) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_featured">
                                <strong>Featured</strong> (Show on homepage)
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="is_active" 
                                   name="is_active" 
                                   value="1"
                                   {{ old('is_active', $testimonial->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                <strong>Active</strong> (Visible on website)
                            </label>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> Update Testimonial
                        </button>
                        <a href="{{ route('admin.testimonials.index') }}" class="btn btn-secondary">
                            <i class="fa fa-times"></i> Cancel
                        </a>
                        <button type="button" 
                                class="btn btn-danger float-end" 
                                data-bs-toggle="modal" 
                                data-bs-target="#deleteModal">
                            <i class="fa fa-trash"></i> Delete
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this testimonial?</p>
                <p class="text-muted">This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('admin.testimonials.destroy', $testimonial->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Testimonial</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function() {
        const preview = document.getElementById('preview');
        const previewContainer = document.getElementById('imagePreview');
        preview.src = reader.result;
        previewContainer.style.display = 'block';
    }
    reader.readAsDataURL(event.target.files[0]);
}
</script>
@endpush