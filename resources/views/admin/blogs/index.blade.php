@extends('admin.layouts.app')

@section('title', 'Manage Blogs')
@section('page-title', 'Manage Blogs')

@section('content')
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">All Blog Posts</h5>
        <div>
            <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> Add New Blog
            </a>
        </div>
    </div>
    
    <!-- Filter & Search Bar -->
    <div class="card-body border-bottom">
        <div class="row align-items-end">
            <div class="col-md-8">
                <form action="{{ route('admin.blogs.index') }}" method="GET" class="row g-3">
                    <div class="col-md-9">
                        <input type="text" 
                               name="search" 
                               class="form-control" 
                               placeholder="Search by title, content, or author..." 
                               value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fa fa-search"></i> Search
                        </button>
                    </div>
                </form>
            </div>
            <div class="col-md-4 text-end">
                <!-- Filter Buttons -->
                <a href="{{ route('admin.blogs.index') }}" 
                   class="btn btn-sm {{ !request('status') ? 'btn-primary' : 'btn-outline-primary' }}">
                    All ({{ \App\Models\Blog::count() }})
                </a>
                <a href="{{ route('admin.blogs.index', ['status' => 'published']) }}" 
                   class="btn btn-sm {{ request('status') == 'published' ? 'btn-success' : 'btn-outline-success' }}">
                    Published ({{ \App\Models\Blog::where('is_published', true)->count() }})
                </a>
                <a href="{{ route('admin.blogs.index', ['status' => 'draft']) }}" 
                   class="btn btn-sm {{ request('status') == 'draft' ? 'btn-warning' : 'btn-outline-warning' }}">
                    Drafts ({{ \App\Models\Blog::where('is_published', false)->count() }})
                </a>
                <a href="{{ route('admin.blogs.index', ['status' => 'featured']) }}" 
                   class="btn btn-sm {{ request('status') == 'featured' ? 'btn-info' : 'btn-outline-info' }}">
                    Featured ({{ \App\Models\Blog::where('is_featured', true)->count() }})
                </a>
            </div>
        </div>
    </div>

    <div class="card-body">
        @if($blogs->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="width: 80px;">Image</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Views</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th style="width: 200px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($blogs as $blog)
                    <tr>
                        <td>
                            @if($blog->featured_image)
                                <img src="{{ asset($blog->featured_image) }}" 
                                     alt="{{ $blog->title }}" 
                                     class="blog-img-thumb">
                            @else
                                <div class="blog-img-thumb bg-secondary d-flex align-items-center justify-content-center">
                                    <i class="fa fa-image text-white"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <strong>{{ Str::limit($blog->title, 50) }}</strong><br>
                            <small class="text-muted">{{ Str::limit($blog->excerpt ?? strip_tags($blog->content), 60) }}</small>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                @if($blog->author_image)
                                    <img src="{{ asset($blog->author_image) }}" 
                                         alt="{{ $blog->author_name }}" 
                                         class="author-img me-2">
                                @endif
                                {{ $blog->author_name }}
                            </div>
                        </td>
                        <td>
                            <i class="fa fa-eye text-muted"></i> {{ number_format($blog->views) }}
                        </td>
                        <td>
                            @if($blog->is_published)
                                <span class="badge bg-success">Published</span>
                            @else
                                <span class="badge bg-warning text-dark">Draft</span>
                            @endif
                            @if($blog->is_featured)
                                <br><span class="badge bg-info mt-1">Featured</span>
                            @endif
                        </td>
                        <td>
                            @if($blog->published_at)
                                <small>{{ $blog->published_at->format('M d, Y') }}</small><br>
                                <small class="text-muted">{{ $blog->reading_time }}</small>
                            @else
                                <small class="text-muted">Not published</small><br>
                                <small class="text-muted">Created: {{ $blog->created_at->format('M d, Y') }}</small>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('blog.show', $blog->slug) }}" 
                                   class="btn btn-sm btn-info btn-action" 
                                   title="View Blog"
                                   target="_blank">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.blogs.edit', $blog->id) }}" 
                                   class="btn btn-sm btn-primary btn-action" 
                                   title="Edit">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.blogs.destroy', $blog->id) }}" 
                                      method="POST" 
                                      class="d-inline" 
                                      onsubmit="return confirm('Are you sure you want to delete this blog post? This action cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-sm btn-danger btn-action" 
                                            title="Delete">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $blogs->appends(request()->query())->links() }}
        </div>
        @else
        <div class="text-center py-5">
            <i class="fa fa-file-text fa-3x text-muted mb-3"></i>
            <p class="text-muted">
                @if(request('search'))
                    No blog posts found matching your search "{{ request('search') }}".
                @else
                    No blog posts found yet. Create your first blog post!
                @endif
            </p>
            @if(request('search') || request('status'))
                <a href="{{ route('admin.blogs.index') }}" class="btn btn-primary">
                    <i class="fa fa-times"></i> Clear Filters
                </a>
            @else
                <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus"></i> Create New Blog
                </a>
            @endif
        </div>
        @endif
    </div>
</div>

<!-- Quick Stats Card -->
<div class="row mt-4">
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="mb-0">{{ \App\Models\Blog::count() }}</h3>
                <p class="text-muted mb-0 small">Total Posts</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-success mb-0">{{ \App\Models\Blog::where('is_published', true)->count() }}</h3>
                <p class="text-muted mb-0 small">Published</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-warning mb-0">{{ \App\Models\Blog::where('is_published', false)->count() }}</h3>
                <p class="text-muted mb-0 small">Drafts</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-info mb-0">{{ number_format(\App\Models\Blog::sum('views')) }}</h3>
                <p class="text-muted mb-0 small">Total Views</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.blog-img-thumb {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 4px;
}
.author-img {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    object-fit: cover;
}
.btn-action {
    margin: 0 2px;
}
</style>
@endpush