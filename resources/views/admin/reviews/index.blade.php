@extends('admin.layouts.app')

@section('title', 'Manage Reviews')
@section('page-title', 'Manage Reviews')

@section('content')
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">All Reviews</h5>
        <div>
            <!-- Filter Buttons -->
            <a href="{{ route('admin.reviews.index') }}" 
               class="btn btn-sm {{ !request('status') ? 'btn-primary' : 'btn-outline-primary' }}">
                All ({{ \App\Models\Review::count() }})
            </a>
            <a href="{{ route('admin.reviews.index', ['status' => 'pending']) }}" 
               class="btn btn-sm {{ request('status') == 'pending' ? 'btn-warning' : 'btn-outline-warning' }}">
                Pending ({{ \App\Models\Review::where('is_approved', false)->count() }})
            </a>
            <a href="{{ route('admin.reviews.index', ['status' => 'approved']) }}" 
               class="btn btn-sm {{ request('status') == 'approved' ? 'btn-success' : 'btn-outline-success' }}">
                Approved ({{ \App\Models\Review::where('is_approved', true)->count() }})
            </a>
        </div>
    </div>
    
    <!-- Search Bar -->
    <div class="card-body border-bottom">
        <form action="{{ route('admin.reviews.index') }}" method="GET" class="row g-3">
            <div class="col-md-10">
                <input type="text" 
                       name="search" 
                       class="form-control" 
                       placeholder="Search by product name, customer name, or comment..." 
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fa fa-search"></i> Search
                </button>
            </div>
        </form>
    </div>

    <div class="card-body">
        @if($reviews->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Customer</th>
                        <th>Rating</th>
                        <th>Comment</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reviews as $review)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                @if($review->saree->featured_image)
                                    {{-- UPDATED: Remove 'storage/' prefix --}}
                                    <img src="{{ asset($review->saree->featured_image) }}" 
                                         alt="{{ $review->saree->name }}" 
                                         class="saree-img-thumb me-2">
                                @else
                                    <div class="saree-img-thumb bg-secondary d-flex align-items-center justify-content-center me-2">
                                        <i class="fa fa-image text-white"></i>
                                    </div>
                                @endif
                                <div>
                                    <strong>{{ Str::limit($review->saree->name, 30) }}</strong><br>
                                    <small class="text-muted">SKU: {{ $review->saree->sku }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <strong>{{ $review->name }}</strong><br>
                            <small class="text-muted">{{ $review->email }}</small>
                        </td>
                        <td>
                            <div class="rating">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating)
                                    <span style="color: #d4af37; font-size: 16px;">★</span>
                                    @else
                                    <span style="color: #ddd; font-size: 16px;">★</span>
                                    @endif
                                @endfor
                                <br>
                                <small class="text-muted">({{ $review->rating }}/5)</small>
                            </div>
                        </td>
                        <td>
                            <div style="max-width: 250px;">
                                {{ Str::limit($review->comment, 80) }}
                                @if(strlen($review->comment) > 80)
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#reviewModal{{ $review->id }}">
                                        <small>Read more</small>
                                    </a>
                                @endif
                            </div>
                            
                            {{-- Display review images if they exist --}}
                            @if(!empty($review->images) && is_array($review->images))
                                <div class="mt-2">
                                    @foreach($review->images as $image)
                                        <img src="{{ asset($image) }}" 
                                             alt="Review image" 
                                             class="review-img-thumb me-1"
                                             data-bs-toggle="modal" 
                                             data-bs-target="#imageModal{{ $review->id }}_{{ $loop->index }}"
                                             style="cursor: pointer;">
                                    @endforeach
                                </div>
                            @endif
                        </td>
                        <td>
                            <small>{{ $review->created_at->format('M d, Y') }}</small><br>
                            <small class="text-muted">{{ $review->created_at->format('h:i A') }}</small>
                        </td>
                        <td>
                            @if($review->is_approved)
                                <span class="badge bg-success">Approved</span>
                            @else
                                <span class="badge bg-warning">Pending</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('product.show', $review->saree->slug) }}" 
                                   class="btn btn-sm btn-info btn-action" 
                                   title="View Product"
                                   target="_blank">
                                    <i class="fa fa-eye"></i>
                                </a>
                                
                                @if(!$review->is_approved)
                                <form action="{{ route('admin.reviews.approve', $review->id) }}" 
                                      method="POST" 
                                      class="d-inline">
                                    @csrf
                                    <button type="submit" 
                                            class="btn btn-sm btn-success btn-action" 
                                            title="Approve">
                                        <i class="fa fa-check"></i>
                                    </button>
                                </form>
                                @else
                                <form action="{{ route('admin.reviews.reject', $review->id) }}" 
                                      method="POST" 
                                      class="d-inline">
                                    @csrf
                                    <button type="submit" 
                                            class="btn btn-sm btn-warning btn-action" 
                                            title="Unapprove">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </form>
                                @endif
                                
                                <form action="{{ route('admin.reviews.destroy', $review->id) }}" 
                                      method="POST" 
                                      class="d-inline" 
                                      onsubmit="return confirm('Are you sure you want to delete this review?')">
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

                    <!-- Review Details Modal -->
                    <div class="modal fade" id="reviewModal{{ $review->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Review Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <strong>Product:</strong> {{ $review->saree->name }}
                                    </div>
                                    <div class="mb-3">
                                        <strong>Customer:</strong> {{ $review->name }} ({{ $review->email }})
                                    </div>
                                    <div class="mb-3">
                                        <strong>Rating:</strong>
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
                                            <span style="color: #d4af37;">★</span>
                                            @else
                                            <span style="color: #ddd;">★</span>
                                            @endif
                                        @endfor
                                        ({{ $review->rating }}/5)
                                    </div>
                                    <div class="mb-3">
                                        <strong>Comment:</strong>
                                        <p class="mt-2">{{ $review->comment }}</p>
                                    </div>
                                    
                                    {{-- Display review images in modal --}}
                                    @if(!empty($review->images) && is_array($review->images))
                                        <div class="mb-3">
                                            <strong>Customer Images:</strong>
                                            <div class="row mt-2">
                                                @foreach($review->images as $image)
                                                    <div class="col-md-4 mb-2">
                                                        <img src="{{ asset($image) }}" 
                                                             alt="Review image" 
                                                             class="img-fluid rounded">
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                    
                                    <div class="mb-3">
                                        <strong>Date:</strong> {{ $review->created_at->format('F d, Y h:i A') }}
                                    </div>
                                    <div>
                                        <strong>Status:</strong>
                                        @if($review->is_approved)
                                            <span class="badge bg-success">Approved</span>
                                        @else
                                            <span class="badge bg-warning">Pending Approval</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    @if(!$review->is_approved)
                                    <form action="{{ route('admin.reviews.approve', $review->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success">
                                            <i class="fa fa-check"></i> Approve Review
                                        </button>
                                    </form>
                                    @endif
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
            {{ $reviews->links() }}
        </div>
        @else
        <div class="text-center py-5">
            <i class="fa fa-star fa-3x text-muted mb-3"></i>
            <p class="text-muted">
                @if(request('search'))
                    No reviews found matching your search.
                @else
                    No reviews found yet. Reviews will appear here once customers start rating products!
                @endif
            </p>
            @if(request('search') || request('status'))
                <a href="{{ route('admin.reviews.index') }}" class="btn btn-primary">Clear Filters</a>
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
                <h3>{{ \App\Models\Review::count() }}</h3>
                <p class="text-muted mb-0">Total Reviews</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-warning">{{ \App\Models\Review::where('is_approved', false)->count() }}</h3>
                <p class="text-muted mb-0">Pending Approval</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-success">{{ \App\Models\Review::where('is_approved', true)->count() }}</h3>
                <p class="text-muted mb-0">Approved</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-info">{{ number_format(\App\Models\Review::avg('rating'), 1) }}</h3>
                <p class="text-muted mb-0">Average Rating</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.rating {
    line-height: 1;
}
.btn-action {
    margin: 0 2px;
}
.modal-body strong {
    color: #2c3e50;
}
.saree-img-thumb {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 4px;
}
.review-img-thumb {
    width: 40px;
    height: 40px;
    object-fit: cover;
    border-radius: 4px;
    border: 1px solid #ddd;
}
.review-img-thumb:hover {
    opacity: 0.8;
    transform: scale(1.05);
    transition: all 0.2s;
}
</style>
@endpush