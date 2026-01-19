@extends('admin.layouts.app')

@section('title', 'Upload New Video')
@section('page-title', 'Upload New Video')

@section('content')
<div class="row">
    <div class="col-md-12">
        <a href="{{ route('admin.videos.index') }}" class="btn btn-secondary mb-3">
            <i class="fa fa-arrow-left"></i> Back to List
        </a>
    </div>
</div>

<form action="{{ route('admin.videos.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <div class="row">
        <!-- Main Content -->
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Video Information</h5>
                </div>
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label for="title" class="form-label">Video Title *</label>
                        <input type="text" 
                               class="form-control @error('title') is-invalid @enderror" 
                               id="title" 
                               name="title" 
                               value="{{ old('title') }}" 
                               placeholder="e.g., Summer Collection Showcase"
                               required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="video_file" class="form-label">Upload Video File *</label>
                        <input type="file" 
                               class="form-control @error('video_file') is-invalid @enderror" 
                               id="video_file" 
                               name="video_file" 
                               accept="video/mp4,video/mov,video/avi,video/wmv"
                               required>
                        <small class="text-muted">
                            Supported formats: MP4, MOV, AVI, WMV (Max: 200MB)<br>
                            Recommended: MP4 format for best compatibility
                        </small>
                        @error('video_file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div id="video-preview" class="mt-3"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-md-4">
            <!-- Settings -->
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Settings</h5>
                </div>
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label for="sort_order" class="form-label">Sort Order</label>
                        <input type="number" 
                               class="form-control @error('sort_order') is-invalid @enderror" 
                               id="sort_order" 
                               name="sort_order" 
                               value="{{ old('sort_order', 0) }}" 
                               min="0"
                               placeholder="0">
                        <small class="text-muted">Lower numbers appear first (0 = highest priority)</small>
                        @error('sort_order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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
                                <strong>Active</strong>
                                <small class="d-block text-muted">Display on website</small>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="card">
                <div class="card-body">
                    <button type="submit" class="btn btn-primary w-100 btn-lg">
                        <i class="fa fa-upload"></i> Upload Video
                    </button>
                    <a href="{{ route('admin.videos.index') }}" class="btn btn-secondary w-100 mt-2">
                        <i class="fa fa-times"></i> Cancel
                    </a>
                </div>
            </div>

            <!-- Info Card -->
            <div class="card mt-3">
                <div class="card-body">
                    <h6 class="mb-2"><i class="fa fa-info-circle text-info"></i> Tips</h6>
                    <ul class="mb-0 small text-muted">
                        <li>Keep videos under 30 seconds for best performance</li>
                        <li>Use landscape orientation (16:9 ratio)</li>
                        <li>Compress videos before upload</li>
                        <li>Last 5 videos will appear on homepage</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
// Video Preview
document.getElementById('video_file').addEventListener('change', function(e) {
    const preview = document.getElementById('video-preview');
    const file = e.target.files[0];
    
    if (file) {
        // Validate file size (200MB)
if (file.size > 209715200) {
    alert('File size should not exceed 200MB');
    this.value = '';
    preview.innerHTML = '';
    return;
}

        // Validate file type
        const validTypes = ['video/mp4', 'video/mov', 'video/avi', 'video/x-msvideo', 'video/x-ms-wmv'];
        if (!validTypes.includes(file.type)) {
            alert('Please upload a valid video file (MP4, MOV, AVI, or WMV)');
            this.value = '';
            preview.innerHTML = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `
                <div class="border rounded p-3 bg-light">
                    <video width="100%" height="auto" controls style="border-radius: 4px;">
                        <source src="${e.target.result}" type="${file.type}">
                        Your browser does not support the video tag.
                    </video>
                    <div class="mt-2">
                        <small class="text-success">
                            <i class="fa fa-check-circle"></i> Video selected successfully
                        </small>
                        <br>
                        <small class="text-muted">
                            Size: ${(file.size / (1024 * 1024)).toFixed(2)} MB
                        </small>
                    </div>
                </div>
            `;
        }
        reader.readAsDataURL(file);
    } else {
        preview.innerHTML = '';
    }
});
</script>
@endpush
@endsection