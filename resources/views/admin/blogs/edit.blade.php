@extends('admin.layouts.app')

@section('title', 'Edit Blog Post')
@section('page-title', 'Edit Blog Post')

@section('content')
<div class="card">
    <div class="card-header bg-white">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Edit Blog Post</h5>
            <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary">
                <i class="fa fa-arrow-left"></i> Back to Blogs
            </a>
        </div>
    </div>
    
    <div class="card-body">
        <form action="{{ route('admin.blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row">
                <!-- Left Column -->
                <div class="col-md-8">
                    <!-- Title -->
                    <div class="form-group">
                        <label for="title" class="form-label">Title *</label>
                        <input type="text" 
                               class="form-control @error('title') is-invalid @enderror" 
                               id="title" 
                               name="title" 
                               value="{{ old('title', $blog->title) }}" 
                               required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Excerpt -->
                    <div class="form-group">
                        <label for="excerpt" class="form-label">Excerpt (Short Description)</label>
                        <textarea class="form-control @error('excerpt') is-invalid @enderror" 
                                  id="excerpt" 
                                  name="excerpt" 
                                  rows="3" 
                                  placeholder="Brief summary of the blog post (optional)">{{ old('excerpt', $blog->excerpt) }}</textarea>
                        @error('excerpt')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Maximum 500 characters</small>
                    </div>

                    <!-- Content -->
                    <div class="form-group">
                        <label for="content" class="form-label">Content *</label>
                        <textarea class="form-control @error('content') is-invalid @enderror" 
                                  id="content" 
                                  name="content" 
                                  rows="15" 
                                  required>{{ old('content', $blog->content) }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">You can use HTML formatting</small>
                    </div>

                    <!-- SEO Section -->
                    <div class="card mt-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">SEO Settings (Optional)</h6>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="meta_title" class="form-label">Meta Title</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="meta_title" 
                                       name="meta_title" 
                                       value="{{ old('meta_title', $blog->meta_title) }}">
                            </div>

                            <div class="form-group">
                                <label for="meta_description" class="form-label">Meta Description</label>
                                <textarea class="form-control" 
                                          id="meta_description" 
                                          name="meta_description" 
                                          rows="2">{{ old('meta_description', $blog->meta_description) }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="meta_keywords" class="form-label">Meta Keywords</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="meta_keywords" 
                                       name="meta_keywords" 
                                       value="{{ old('meta_keywords', $blog->meta_keywords) }}" 
                                       placeholder="keyword1, keyword2, keyword3">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-md-4">
                    <!-- Current Featured Image -->
                    @if($blog->featured_image)
                    <div class="form-group">
                        <label class="form-label">Current Featured Image</label>
                        <div class="mb-2">
                            <img src="{{ asset($blog->featured_image) }}" 
                                 alt="{{ $blog->title }}" 
                                 class="img-thumbnail" 
                                 style="max-width: 100%;">
                        </div>
                    </div>
                    @endif

                    <!-- Featured Image -->
                    <div class="form-group">
                        <label for="featured_image" class="form-label">
                            {{ $blog->featured_image ? 'Change Featured Image' : 'Featured Image' }}
                        </label>
                        <input type="file" 
                               class="form-control @error('featured_image') is-invalid @enderror" 
                               id="featured_image" 
                               name="featured_image" 
                               accept="image/*"
                               onchange="previewImage(event, 'featured-preview')">
                        @error('featured_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div id="featured-preview" class="mt-2"></div>
                    </div>

                    <!-- Author Name -->
                    <div class="form-group">
                        <label for="author_name" class="form-label">Author Name *</label>
                        <input type="text" 
                               class="form-control @error('author_name') is-invalid @enderror" 
                               id="author_name" 
                               name="author_name" 
                               value="{{ old('author_name', $blog->author_name) }}" 
                               required>
                        @error('author_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Current Author Image -->
                    @if($blog->author_image)
                    <div class="form-group">
                        <label class="form-label">Current Author Image</label>
                        <div class="mb-2">
                            <img src="{{ asset($blog->author_image) }}" 
                                 alt="{{ $blog->author_name }}" 
                                 class="rounded-circle" 
                                 style="width: 80px; height: 80px; object-fit: cover;">
                        </div>
                    </div>
                    @endif

                    <!-- Author Image -->
                    <div class="form-group">
                        <label for="author_image" class="form-label">
                            {{ $blog->author_image ? 'Change Author Image' : 'Author Image' }}
                        </label>
                        <input type="file" 
                               class="form-control @error('author_image') is-invalid @enderror" 
                               id="author_image" 
                               name="author_image" 
                               accept="image/*"
                               onchange="previewImage(event, 'author-preview')">
                        @error('author_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div id="author-preview" class="mt-2"></div>
                    </div>

                    <!-- Published Date -->
                    <div class="form-group">
                        <label for="published_at" class="form-label">Published Date</label>
                        <input type="datetime-local" 
                               class="form-control" 
                               id="published_at" 
                               name="published_at" 
                               value="{{ old('published_at', $blog->published_at ? $blog->published_at->format('Y-m-d\TH:i') : '') }}">
                        <small class="text-muted">Leave empty to use current date/time</small>
                    </div>

                    <!-- Status Options -->
                    <div class="card">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Status</h6>
                        </div>
                        <div class="card-body">
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="is_published" 
                                       name="is_published" 
                                       value="1" 
                                       {{ old('is_published', $blog->is_published) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_published">
                                    Publish this post
                                </label>
                            </div>

                            <div class="form-check mt-2">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="is_featured" 
                                       name="is_featured" 
                                       value="1" 
                                       {{ old('is_featured', $blog->is_featured) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_featured">
                                    Mark as Featured
                                </label>
                            </div>

                            <div class="mt-3">
                                <small class="text-muted">
                                    <i class="fa fa-eye"></i> Views: {{ $blog->views }}<br>
                                    Created: {{ $blog->created_at->format('M d, Y') }}
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> Update Blog Post
                        </button>
                        <a href="{{ route('admin.blogs.index') }}" class="btn btn-outline-secondary">
                            Cancel
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function previewImage(event, previewId) {
    const preview = document.getElementById(previewId);
    const file = event.target.files[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" class="img-thumbnail mt-2" style="max-width: 100%; max-height: 200px;">`;
        }
        reader.readAsDataURL(file);
    } else {
        preview.innerHTML = '';
    }
}
</script>
@endpush