@extends('admin.layouts.app')

@section('title', 'View Collection')
@section('page-title', 'View Collection')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ $collection->name }}</h5>
                <div>
                    <a href="{{ route('admin.collections.edit', $collection) }}" class="btn btn-sm btn-warning">
                        <i class="fa fa-edit"></i> Edit
                    </a>
                    <a href="{{ route('collections.show', $collection->slug) }}" 
                       class="btn btn-sm btn-info" 
                       target="_blank">
                        <i class="fa fa-external-link"></i> View on Site
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    @if($collection->image)
                    <div class="col-md-6">
                        <h6>Collection Image</h6>
                        <img src="{{ asset($collection->image) }}" 
                             alt="{{ $collection->name }}" 
                             class="img-fluid rounded">
                    </div>
                    @endif

                    @if($collection->banner_image)
                    <div class="col-md-6">
                        <h6>Banner Image</h6>
                        <img src="{{ asset($collection->banner_image) }}" 
                             alt="{{ $collection->name }} Banner" 
                             class="img-fluid rounded">
                    </div>
                    @endif
                </div>

                @if($collection->description)
                <div class="mb-4">
                    <h6>Description</h6>
                    <p>{{ $collection->description }}</p>
                </div>
                @endif

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <strong>Status:</strong><br>
                        @if($collection->is_active)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Sort Order:</strong><br>
                        {{ $collection->sort_order ?? 'Not Set' }}
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Launch Date:</strong><br>
                        @if($collection->launch_date)
                            {{ $collection->launch_date->format('M d, Y') }}
                            @if($collection->launch_date->isFuture())
                                <span class="badge bg-warning">Coming Soon</span>
                            @endif
                        @else
                            Not Set
                        @endif
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Created:</strong><br>
                        {{ $collection->created_at->format('M d, Y h:i A') }}
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Last Updated:</strong><br>
                        {{ $collection->updated_at->format('M d, Y h:i A') }}
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Slug:</strong><br>
                        <code>{{ $collection->slug }}</code>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Sarees in this Collection (Latest 10)</h5>
            </div>
            <div class="card-body">
                @if($collection->sarees->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>SKU</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($collection->sarees as $saree)
                            <tr>
                                <td>
                                    @if($saree->featured_image)
                                        <img src="{{ asset($saree->featured_image) }}" 
                                             alt="{{ $saree->name }}" 
                                             class="saree-img-thumb">
                                    @else
                                        <div class="saree-img-thumb bg-secondary d-flex align-items-center justify-content-center">
                                            <i class="fa fa-image text-white"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>{{ $saree->name }}</td>
                                <td>{{ $saree->sku }}</td>
                                <td>
                                    @if($saree->sale_price)
                                        <span class="text-danger">₹{{ number_format($saree->sale_price, 2) }}</span>
                                    @else
                                        ₹{{ number_format($saree->price, 2) }}
                                    @endif
                                </td>
                                <td>{{ $saree->stock_quantity }}</td>
                                <td>
                                    @if($saree->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.sarees.show', $saree) }}" 
                                       class="btn btn-sm btn-info">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.sarees.edit', $saree) }}" 
                                       class="btn btn-sm btn-warning">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($collection->sarees()->count() > 10)
                <div class="alert alert-info mt-3">
                    Showing 10 of {{ $collection->sarees()->count() }} sarees. 
                    <a href="{{ route('admin.sarees.index', ['collection' => $collection->id]) }}">View all sarees in this collection</a>
                </div>
                @endif
                @else
                <div class="text-center py-4">
                    <i class="fa fa-shopping-bag fa-3x text-muted mb-3"></i>
                    <p class="text-muted">No sarees in this collection yet.</p>
                    <a href="{{ route('admin.sarees.create', ['collection' => $collection->id]) }}" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Add Saree to Collection
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Statistics</h5>
            </div>
            <div class="card-body">
                <div class="mb-3 p-3 bg-light rounded">
                    <h3 class="mb-0">{{ $collection->sarees()->count() }}</h3>
                    <small class="text-muted">Total Sarees</small>
                </div>

                <div class="mb-3 p-3 bg-light rounded">
                    <h3 class="mb-0">{{ $collection->activeSarees()->count() }}</h3>
                    <small class="text-muted">Active Sarees</small>
                </div>

                <div class="mb-3 p-3 bg-light rounded">
                    <h3 class="mb-0">{{ $collection->sarees()->where('stock_quantity', '>', 0)->count() }}</h3>
                    <small class="text-muted">In Stock</small>
                </div>

                <div class="mb-3 p-3 bg-light rounded">
                    <h3 class="mb-0">₹{{ number_format($collection->sarees()->sum('price'), 2) }}</h3>
                    <small class="text-muted">Total Inventory Value</small>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header bg-white">
                <h5 class="mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <a href="{{ route('admin.sarees.create', ['collection' => $collection->id]) }}" 
                   class="btn btn-primary w-100 mb-2">
                    <i class="fa fa-plus"></i> Add Saree to Collection
                </a>
                <a href="{{ route('admin.collections.edit', $collection) }}" 
                   class="btn btn-warning w-100 mb-2">
                    <i class="fa fa-edit"></i> Edit Collection
                </a>
                <form action="{{ route('admin.collections.destroy', $collection) }}" 
                      method="POST" 
                      onsubmit="return confirm('Are you sure? This will only work if there are no sarees in this collection.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100">
                        <i class="fa fa-trash"></i> Delete Collection
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection