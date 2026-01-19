@extends('admin.layouts.app')

@section('title', 'Manage Videos')
@section('page-title', 'Manage Videos')

@section('content')
<div class="row mb-3">
    <div class="col-md-12">
        <a href="{{ route('admin.videos.create') }}" class="btn btn-primary">
            <i class="fa fa-plus"></i> Upload New Video
        </a>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="card">
    <div class="card-header bg-white">
        <h5 class="mb-0">All Videos ({{ $videos->total() }})</h5>
    </div>
    <div class="card-body">
        @if($videos->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th width="5%">#</th>
                        <th width="15%">Preview</th>
                        <th width="30%">Title</th>
                        <th width="10%">Sort Order</th>
                        <th width="10%">Status</th>
                        <th width="15%">Uploaded</th>
                        <th width="15%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($videos as $video)
                    <tr>
                        <td>{{ $video->id }}</td>
                        <td>
                            <video width="150" height="100" style="object-fit: cover; border-radius: 4px;" muted>
                                <source src="{{ asset($video->video_path) }}" type="video/mp4">
                            </video>
                        </td>
                        <td>
                            <strong>{{ $video->title }}</strong>
                        </td>
                        <td>
                            <span class="badge bg-secondary">{{ $video->sort_order }}</span>
                        </td>
                        <td>
                            <div class="form-check form-switch">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       {{ $video->is_active ? 'checked' : '' }}
                                       onchange="toggleActive({{ $video->id }})"
                                       id="active-{{ $video->id }}">
                                <label class="form-check-label" for="active-{{ $video->id }}">
                                    <span class="badge bg-{{ $video->is_active ? 'success' : 'secondary' }}" 
                                          id="badge-{{ $video->id }}">
                                        {{ $video->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </label>
                            </div>
                        </td>
                        <td>
                            <small class="text-muted">
                                {{ $video->created_at->format('M d, Y') }}<br>
                                {{ $video->created_at->format('h:i A') }}
                            </small>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.videos.edit', $video) }}" 
                                   class="btn btn-sm btn-warning"
                                   title="Edit">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.videos.destroy', $video) }}" 
                                      method="POST" 
                                      style="display: inline;"
                                      onsubmit="return confirm('Are you sure you want to delete this video?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-sm btn-danger"
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

        <div class="mt-3">
            {{ $videos->links() }}
        </div>
        @else
        <div class="text-center py-5">
            <i class="fa fa-video fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">No videos uploaded yet</h5>
            <p class="text-muted">Start by uploading your first video</p>
            <a href="{{ route('admin.videos.create') }}" class="btn btn-primary mt-2">
                <i class="fa fa-plus"></i> Upload Video
            </a>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
function toggleActive(videoId) {
    fetch(`/admin/videos/${videoId}/toggle-active`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const badge = document.getElementById(`badge-${videoId}`);
            if (data.is_active) {
                badge.classList.remove('bg-secondary');
                badge.classList.add('bg-success');
                badge.textContent = 'Active';
            } else {
                badge.classList.remove('bg-success');
                badge.classList.add('bg-secondary');
                badge.textContent = 'Inactive';
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to update status');
    });
}

// Play video on hover
document.querySelectorAll('video').forEach(video => {
    video.addEventListener('mouseenter', function() {
        this.play();
    });
    
    video.addEventListener('mouseleave', function() {
        this.pause();
        this.currentTime = 0;
    });
});
</script>
@endpush
@endsection