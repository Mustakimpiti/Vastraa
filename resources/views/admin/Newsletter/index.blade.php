@extends('admin.layouts.app')

@section('title', 'Newsletter Subscribers')
@section('page-title', 'Newsletter Subscribers')

@section('content')
<!-- Quick Stats Card -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card text-center">
            <div class="card-body">
                <h3>{{ $stats['total'] }}</h3>
                <p class="text-muted mb-0">Total Subscribers</p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-success">{{ $stats['active'] }}</h3>
                <p class="text-muted mb-0">Active Subscribers</p>
            </div>
        </div>
    </div>
    
</div>

<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">All Subscribers</h5>
        <div>
            <!-- Filter Buttons -->
            <a href="{{ route('admin.newsletter.index') }}" 
               class="btn btn-sm {{ !request('status') ? 'btn-primary' : 'btn-outline-primary' }}">
                All ({{ $stats['total'] }})
            </a>
            <a href="{{ route('admin.newsletter.index', ['status' => 'active']) }}" 
               class="btn btn-sm {{ request('status') == 'active' ? 'btn-success' : 'btn-outline-success' }}">
                Active ({{ $stats['active'] }})
            </a>
           
        </div>
    </div>
    
    <!-- Search and Export Bar -->
    <div class="card-body border-bottom">
        <div class="row g-3">
            <div class="col-md-8">
                <form action="{{ route('admin.newsletter.index') }}" method="GET" class="d-flex">
                    <input type="text" 
                           name="search" 
                           class="form-control" 
                           placeholder="Search by email..." 
                           value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary ms-2">
                        <i class="fa fa-search"></i> Search
                    </button>
                </form>
            </div>
            <div class="col-md-4 text-end">
                <form action="{{ route('admin.newsletter.export') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-download"></i> Export to CSV
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="card-body">
        @if($subscribers->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Subscribed Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subscribers as $subscriber)
                    <tr>
                        <td>{{ $subscribers->firstItem() + $loop->index }}</td>
                        <td>
                            <strong>{{ $subscriber->email }}</strong>
                        </td>
                        <td>
                            @if($subscriber->status === 'active')
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Unsubscribed</span>
                            @endif
                        </td>
                        <td>
                            <small>{{ $subscriber->subscribed_at->format('M d, Y') }}</small><br>
                            <small class="text-muted">{{ $subscriber->subscribed_at->format('h:i A') }}</small>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <button type="button" 
                                        class="btn btn-sm btn-info btn-action" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#subscriberModal{{ $subscriber->id }}"
                                        title="View Details">
                                    <i class="fa fa-eye"></i>
                                </button>
                                
                                <form action="{{ route('admin.newsletter.destroy', $subscriber->id) }}" 
                                      method="POST" 
                                      class="d-inline" 
                                      onsubmit="return confirm('Are you sure you want to delete this subscriber?')">
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

                    <!-- Subscriber Details Modal -->
                    <div class="modal fade" id="subscriberModal{{ $subscriber->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Subscriber Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <strong>Email:</strong>
                                        <p class="mt-1">{{ $subscriber->email }}</p>
                                    </div>
                                    @if($subscriber->name)
                                    <div class="mb-3">
                                        <strong>Name:</strong>
                                        <p class="mt-1">{{ $subscriber->name }}</p>
                                    </div>
                                    @endif
                                    <div class="mb-3">
                                        <strong>Status:</strong>
                                        <p class="mt-1">
                                            @if($subscriber->status === 'active')
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-secondary">Unsubscribed</span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <strong>Subscribed On:</strong>
                                        <p class="mt-1">{{ $subscriber->subscribed_at->format('F d, Y h:i A') }}</p>
                                    </div>
                                    @if($subscriber->unsubscribed_at)
                                    <div class="mb-3">
                                        <strong>Unsubscribed On:</strong>
                                        <p class="mt-1">{{ $subscriber->unsubscribed_at->format('F d, Y h:i A') }}</p>
                                    </div>
                                    @endif
                                    <div>
                                        <strong>Duration:</strong>
                                        <p class="mt-1">
                                            {{ $subscriber->subscribed_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $subscribers->links() }}
        </div>
        @else
        <div class="text-center py-5">
            <i class="fa fa-envelope fa-3x text-muted mb-3"></i>
            <p class="text-muted">
                @if(request('search'))
                    No subscribers found matching your search.
                @else
                    No newsletter subscribers yet. Subscribers will appear here when people sign up!
                @endif
            </p>
            @if(request('search') || request('status'))
                <a href="{{ route('admin.newsletter.index') }}" class="btn btn-primary">Clear Filters</a>
            @endif
        </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
.btn-action {
    margin: 0 2px;
}
.modal-body strong {
    color: #2c3e50;
}
</style>
@endpush