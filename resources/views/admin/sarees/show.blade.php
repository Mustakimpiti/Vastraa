@extends('admin.layouts.app')

@section('title', 'View Saree - ' . $saree->name)
@section('page-title', 'View Saree Details')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="mb-3">
            <a href="{{ route('admin.sarees.index') }}" class="btn btn-secondary">
                <i class="fa fa-arrow-left"></i> Back to List
            </a>
            <a href="{{ route('admin.sarees.edit', $saree) }}" class="btn btn-warning">
                <i class="fa fa-edit"></i> Edit
            </a>
            <form action="{{ route('admin.sarees.destroy', $saree) }}" 
                  method="POST" 
                  class="d-inline"
                  onsubmit="return confirm('Are you sure you want to delete this saree?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="fa fa-trash"></i> Delete
                </button>
            </form>
        </div>
    </div>
</div>

<div class="row">
    <!-- Main Content -->
    <div class="col-md-8">
        <!-- Basic Information -->
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Basic Information</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-3 fw-bold">Name:</div>
                    <div class="col-md-9">{{ $saree->name }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3 fw-bold">SKU:</div>
                    <div class="col-md-9">{{ $saree->sku }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3 fw-bold">Slug:</div>
                    <div class="col-md-9">{{ $saree->slug }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3 fw-bold">Fabric:</div>
                    <div class="col-md-9">{{ $saree->fabric }}</div>
                </div>
                @if($saree->short_description)
                <div class="row mb-3">
                    <div class="col-md-3 fw-bold">Short Description:</div>
                    <div class="col-md-9">{{ $saree->short_description }}</div>
                </div>
                @endif
                @if($saree->description)
                <div class="row mb-3">
                    <div class="col-md-3 fw-bold">Full Description:</div>
                    <div class="col-md-9">{{ $saree->description }}</div>
                </div>
                @endif
            </div>
        </div>

        <!-- Saree Details -->
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Saree Details</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <div class="col-6 fw-bold">Length:</div>
                            <div class="col-6">{{ $saree->length }} meters</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6 fw-bold">Blouse Length:</div>
                            <div class="col-6">{{ $saree->blouse_length }} meters</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6 fw-bold">Blouse Included:</div>
                            <div class="col-6">
                                @if($saree->blouse_included)
                                    <span class="badge bg-success">Yes</span>
                                @else
                                    <span class="badge bg-secondary">No</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        @if($saree->work_type)
                        <div class="row mb-3">
                            <div class="col-6 fw-bold">Work Type:</div>
                            <div class="col-6">{{ $saree->work_type }}</div>
                        </div>
                        @endif
                        @if($saree->occasion)
                        <div class="row mb-3">
                            <div class="col-6 fw-bold">Occasion:</div>
                            <div class="col-6">{{ $saree->occasion }}</div>
                        </div>
                        @endif
                        @if($saree->pattern)
                        <div class="row mb-3">
                            <div class="col-6 fw-bold">Pattern:</div>
                            <div class="col-6">{{ $saree->pattern }}</div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Statistics</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="text-center p-3 bg-light rounded">
                            <h4>{{ $saree->views }}</h4>
                            <p class="mb-0 text-muted">Views</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center p-3 bg-light rounded">
                            <h4>{{ number_format($saree->avg_rating, 1) }} <i class="fa fa-star text-warning"></i></h4>
                            <p class="mb-0 text-muted">Rating</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center p-3 bg-light rounded">
                            <h4>{{ $saree->total_reviews }}</h4>
                            <p class="mb-0 text-muted">Reviews</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-md-4">
        <!-- Featured Image -->
        @if($saree->featured_image)
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Featured Image</h5>
            </div>
            <div class="card-body">
                <img src="{{ asset('storage/' . $saree->featured_image) }}" 
                     class="img-fluid" 
                     alt="{{ $saree->name }}">
            </div>
        </div>
        @endif

        <!-- Pricing & Stock -->
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Pricing & Stock</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-6 fw-bold">Regular Price:</div>
                    <div class="col-6">₹{{ number_format($saree->price, 2) }}</div>
                </div>
                @if($saree->sale_price)
                <div class="row mb-3">
                    <div class="col-6 fw-bold">Sale Price:</div>
                    <div class="col-6 text-danger">₹{{ number_format($saree->sale_price, 2) }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-6 fw-bold">Discount:</div>
                    <div class="col-6">
                        <span class="badge bg-danger">{{ $saree->getDiscountPercentage() }}% OFF</span>
                    </div>
                </div>
                @endif
                <div class="row mb-3">
                    <div class="col-6 fw-bold">Stock:</div>
                    <div class="col-6">
                        @if($saree->stock_quantity > 10)
                            <span class="badge bg-success">{{ $saree->stock_quantity }} units</span>
                        @elseif($saree->stock_quantity > 0)
                            <span class="badge bg-warning">{{ $saree->stock_quantity }} units</span>
                        @else
                            <span class="badge bg-danger">Out of Stock</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Collection -->
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Collection</h5>
            </div>
            <div class="card-body">
                @if($saree->collection)
                    <p class="mb-0"><strong>{{ $saree->collection->name }}</strong></p>
                    @if($saree->collection->description)
                        <p class="text-muted small mb-0">{{ Str::limit($saree->collection->description, 100) }}</p>
                    @endif
                @else
                    <p class="text-muted mb-0">No collection assigned</p>
                @endif
            </div>
        </div>

        <!-- Status -->
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Status</h5>
            </div>
            <div class="card-body">
                <div class="mb-2">
                    @if($saree->is_active)
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-secondary">Inactive</span>
                    @endif
                </div>
                @if($saree->is_featured)
                    <div class="mb-2">
                        <span class="badge bg-primary">Featured</span>
                    </div>
                @endif
                @if($saree->is_new_arrival)
                    <div class="mb-2">
                        <span class="badge bg-info">New Arrival</span>
                    </div>
                @endif
                @if($saree->is_bestseller)
                    <div class="mb-2">
                        <span class="badge bg-warning">Bestseller</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Timestamps -->
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Timestamps</h5>
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-5 fw-bold">Created:</div>
                    <div class="col-7 small">{{ $saree->created_at->format('M d, Y H:i') }}</div>
                </div>
                <div class="row">
                    <div class="col-5 fw-bold">Updated:</div>
                    <div class="col-7 small">{{ $saree->updated_at->format('M d, Y H:i') }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection