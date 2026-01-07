@extends('admin.layouts.app')

@section('title', 'Edit Collection')
@section('page-title', 'Edit Collection')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Edit Collection: {{ $collection->name }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.collections.update', $collection) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label class="form-label">Collection Name *</label>
                        <input type="text" 
                               name="name" 
                               class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name', $collection->name) }}" 
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Description</label>
                        <textarea name="description" 
                                  class="form-control @error('description') is-invalid @enderror" 
                                  rows="4">{{ old('description', $collection->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Collection Image</label>
                                @if($collection->image)
                                    <div class="mb-2">
                                        <img src="{{ asset($collection->image) }}" 
                                             alt="{{ $collection->name }}" 
                                             class="img-thumbnail" 
                                             style="max-width: 200px;">
                                    </div>
                                @endif
                                <input type="file" 
                                       name="image" 
                                       class="form-control @error('image') is-invalid @enderror"
                                       accept="image/*"
                                       onchange="previewImage(this, 'imagePreview')">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Leave empty to keep current image</small>
                                <div id="imagePreview" class="mt-2"></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Banner Image</label>
                                @if($collection->banner_image)
                                    <div class="mb-2">
                                        <img src="{{ asset($collection->banner_image) }}" 
                                             alt="{{ $collection->name }} Banner" 
                                             class="img-thumbnail" 
                                             style="max-width: 200px;">
                                    </div>
                                @endif
                                <input type="file" 
                                       name="banner_image" 
                                       class="form-control @error('banner_image') is-invalid @enderror"
                                       accept="image/*"
                                       onchange="previewImage(this, 'bannerPreview')">
                                @error('banner_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Leave empty to keep current banner</small>
                                <div id="bannerPreview" class="mt-2"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Sort Order</label>
                                <input type="number" 
                                       name="sort_order" 
                                       class="form-control @error('sort_order') is-invalid @enderror" 
                                       value="{{ old('sort_order', $collection->sort_order) }}">
                                @error('sort_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Launch Date</label>
                                <input type="date" 
                                       name="launch_date" 
                                       class="form-control @error('launch_date') is-invalid @enderror" 
                                       value="{{ old('launch_date', $collection->launch_date?->format('Y-m-d')) }}">
                                @error('launch_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" 
                                   name="is_active" 
                                   class="form-check-input" 
                                   id="is_active" 
                                   value="1"
                                   {{ old('is_active', $collection->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Active (Display on website)
                            </label>
                        </div>
                    </div>

                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> Update Collection
                        </button>
                        <a href="{{ route('admin.collections.index') }}" class="btn btn-secondary">
                            <i class="fa fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Collection Stats</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Total Sarees:</strong> {{ $collection->sarees()->count() }}
                </div>
                <div class="mb-3">
                    <strong>Active Sarees:</strong> {{ $collection->activeSarees()->count() }}
                </div>
                <div class="mb-3">
                    <strong>Created:</strong> {{ $collection->created_at->format('M d, Y') }}
                </div>
                <div class="mb-3">
                    <strong>Last Updated:</strong> {{ $collection->updated_at->format('M d, Y') }}
                </div>
                <hr>
                <a href="{{ route('collections.show', $collection->slug) }}" 
                   class="btn btn-sm btn-info w-100" 
                   target="_blank">
                    <i class="fa fa-external-link"></i> View on Website
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    preview.innerHTML = '';
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.maxWidth = '200px';
            img.style.marginTop = '10px';
            img.className = 'img-thumbnail';
            preview.appendChild(img);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
@endsection