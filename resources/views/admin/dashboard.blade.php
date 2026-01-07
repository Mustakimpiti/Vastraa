@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="row">
    <!-- Quick Stats -->
    <div class="col-md-3">
        <div class="card text-center mb-4">
            <div class="card-body">
                <i class="fa fa-shopping-bag fa-3x text-primary mb-3"></i>
                <h3>{{ \App\Models\Saree::count() }}</h3>
                <p class="text-muted mb-0">Total Sarees</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center mb-4">
            <div class="card-body">
                <i class="fa fa-check-circle fa-3x text-success mb-3"></i>
                <h3>{{ \App\Models\Saree::where('is_active', true)->count() }}</h3>
                <p class="text-muted mb-0">Active Sarees</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center mb-4">
            <div class="card-body">
                <i class="fa fa-cube fa-3x text-warning mb-3"></i>
                <h3>{{ \App\Models\Saree::where('stock_quantity', '>', 0)->count() }}</h3>
                <p class="text-muted mb-0">In Stock</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center mb-4">
            <div class="card-body">
                <i class="fa fa-folder fa-3x text-info mb-3"></i>
                <h3>{{ \App\Models\Collection::count() }}</h3>
                <p class="text-muted mb-0">Collections</p>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <a href="{{ route('admin.sarees.create') }}" class="btn btn-primary me-2 mb-2">
                    <i class="fa fa-plus"></i> Add New Saree
                </a>
                <a href="{{ route('admin.sarees.index') }}" class="btn btn-secondary me-2 mb-2">
                    <i class="fa fa-list"></i> View All Sarees
                </a>
                <a href="{{ route('home') }}" target="_blank" class="btn btn-info mb-2">
                    <i class="fa fa-external-link"></i> View Website
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Recent Sarees -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Recently Added Sarees</h5>
                <a href="{{ route('admin.sarees.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
                @php
                    $recentSarees = \App\Models\Saree::with('collection')->latest()->take(5)->get();
                @endphp
                
                @if($recentSarees->count() > 0)
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
                            @foreach($recentSarees as $saree)
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
                                <td>
                                    <strong>{{ $saree->name }}</strong><br>
                                    <small class="text-muted">{{ $saree->collection->name ?? 'No Collection' }}</small>
                                </td>
                                <td>{{ $saree->sku }}</td>
                                <td>
                                    @if($saree->sale_price)
                                        <span class="text-danger">₹{{ number_format($saree->sale_price, 2) }}</span>
                                    @else
                                        <span>₹{{ number_format($saree->price, 2) }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($saree->stock_quantity > 10)
                                        <span class="badge bg-success">{{ $saree->stock_quantity }}</span>
                                    @elseif($saree->stock_quantity > 0)
                                        <span class="badge bg-warning">{{ $saree->stock_quantity }}</span>
                                    @else
                                        <span class="badge bg-danger">Out</span>
                                    @endif
                                </td>
                                <td>
                                    @if($saree->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.sarees.edit', $saree) }}" 
                                       class="btn btn-sm btn-warning"
                                       title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-4">
                    <i class="fa fa-shopping-bag fa-3x text-muted mb-3"></i>
                    <p class="text-muted">No sarees added yet. Start by adding your first saree!</p>
                    <a href="{{ route('admin.sarees.create') }}" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Add First Saree
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Low Stock Alert -->
@php
    $lowStockSarees = \App\Models\Saree::where('is_active', true)
        ->where('stock_quantity', '>', 0)
        ->where('stock_quantity', '<=', 5)
        ->get();
@endphp

@if($lowStockSarees->count() > 0)
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card border-warning">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0"><i class="fa fa-exclamation-triangle"></i> Low Stock Alert</h5>
            </div>
            <div class="card-body">
                <p class="mb-3">The following sarees have low stock (5 or fewer items):</p>
                <ul class="list-unstyled">
                    @foreach($lowStockSarees as $saree)
                    <li class="mb-2">
                        <strong>{{ $saree->name }}</strong> (SKU: {{ $saree->sku }}) - 
                        <span class="badge bg-warning">{{ $saree->stock_quantity }} units left</span>
                        <a href="{{ route('admin.sarees.edit', $saree) }}" class="btn btn-sm btn-outline-warning ms-2">
                            Update Stock
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endif
@endsection