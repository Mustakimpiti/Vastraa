@extends('admin.layouts.app')

@section('title', 'Manage Collections')
@section('page-title', 'Manage Collections')

@section('content')
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">All Collections</h5>
        <a href="{{ route('admin.collections.create') }}" class="btn btn-primary">
            <i class="fa fa-plus"></i> Add New Collection
        </a>
    </div>
    <div class="card-body">
        @if($collections->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Sarees Count</th>
                        <th>Sort Order</th>
                        <th>Launch Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($collections as $collection)
                    <tr>
                        <td>
                            @if($collection->image)
                                <img src="{{ asset($collection->image) }}" 
                                     alt="{{ $collection->name }}" 
                                     class="saree-img-thumb">
                            @else
                                <div class="saree-img-thumb bg-secondary d-flex align-items-center justify-content-center">
                                    <i class="fa fa-image text-white"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <strong>{{ $collection->name }}</strong><br>
                            @if($collection->description)
                                <small class="text-muted">{{ Str::limit($collection->description, 50) }}</small>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-info">{{ $collection->sarees_count }} {{ Str::plural('Saree', $collection->sarees_count) }}</span>
                        </td>
                        <td>{{ $collection->sort_order ?? '-' }}</td>
                        <td>
                            @if($collection->launch_date)
                                {{ $collection->launch_date->format('M d, Y') }}
                                @if($collection->launch_date->isFuture())
                                    <br><small class="badge bg-warning">Coming Soon</small>
                                @elseif($collection->launch_date->isToday())
                                    <br><small class="badge bg-success">Launching Today</small>
                                @endif
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if($collection->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.collections.show', $collection) }}" 
                               class="btn btn-sm btn-info btn-action" 
                               title="View">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.collections.edit', $collection) }}" 
                               class="btn btn-sm btn-warning btn-action" 
                               title="Edit">
                                <i class="fa fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.collections.destroy', $collection) }}" 
                                  method="POST" 
                                  class="d-inline"
                                  onsubmit="return confirm('Are you sure you want to delete this collection?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="btn btn-sm btn-danger btn-action" 
                                        title="Delete">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $collections->links() }}
        </div>
        @else
        <div class="text-center py-5">
            <i class="fa fa-folder-open fa-3x text-muted mb-3"></i>
            <p class="text-muted">No collections found. Add your first collection to get started!</p>
            <a href="{{ route('admin.collections.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> Add New Collection
            </a>
        </div>
        @endif
    </div>
</div>
@endsection