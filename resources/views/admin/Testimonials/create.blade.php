@extends('admin.layouts.app')

@section('title', 'Add New Testimonial')
@section('page-title', 'Add New Testimonial')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Testimonial Information</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Customer Name -->
                    <div class="form-group">
                        <label for="customer_name" class="form-label">Customer Name <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('customer_name') is-invalid @enderror" 
                               id="customer_name" 
                               name="customer_name" 
                               value="{{ old('customer_name') }}" 
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
                               value="{{ old('customer_location') }}" 
                               placeholder="e.g., Mumbai, India">
                        @error('customer_location')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Customer Image -->
                    <div class="form-group">
                        <label for="customer_image" class="form-label">Customer Image</label>
                        <input type="file" 
                               class="form-control @error('customer_image') is-invalid @enderror" 
                               id="customer_image" 
                               name="customer_image" 
                               accept="image/*"
                               onchange="previewImage(event)">
                        <small class="text-muted">Recommended: Square image (e.g., 300x300px)</small>
                        @error('customer_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        
                        <!-- Image Preview -->
                        <div id="imagePreview" class="mt-3" style="display: none;">
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
                                  required>{{ old('testimonial') }}</textarea>
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
                                <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>
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
                               value="{{ old('sort_order', 0) }}" 
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
                                   {{ old('is_featured') ? 'checked' : '' }}>
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
                                   {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                <strong>Active</strong> (Visible on website)
                            </label>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> Save Testimonial
                        </button>
                        <a href="{{ route('admin.testimonials.index') }}" class="btn btn-secondary">
                            <i class="fa fa-times"></i> Cancel
                        </a>
                    </div>
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