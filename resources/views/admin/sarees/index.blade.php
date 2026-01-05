@extends('admin.layouts.app')

@section('title', 'Manage Sarees')
@section('page-title', 'Manage Sarees')

@section('content')
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">All Sarees</h5>
        <a href="{{ route('admin.sarees.create') }}" class="btn btn-primary">
            <i class="fa fa-plus"></i> Add New Saree
        </a>
    </div>
    <div class="card-body">
        @if($sarees->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>SKU</th>
                        <th>Fabric</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sarees as $saree)
                    <tr>
                        <td>
                            @if($saree->featured_image)
                                <img src="{{ asset('storage/' . $saree->featured_image) }}" 
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
                        <td>{{ $saree->fabric }}</td>
                        <td>
                            @if($saree->sale_price)
                                <span class="text-decoration-line-through text-muted">₹{{ number_format($saree->price, 2) }}</span><br>
                                <span class="text-danger fw-bold">₹{{ number_format($saree->sale_price, 2) }}</span>
                            @else
                                <span class="fw-bold">₹{{ number_format($saree->price, 2) }}</span>
                            @endif
                        </td>
                        <td>
                            @if($saree->stock_quantity > 10)
                                <span class="badge bg-success">{{ $saree->stock_quantity }}</span>
                            @elseif($saree->stock_quantity > 0)
                                <span class="badge bg-warning">{{ $saree->stock_quantity }}</span>
                            @else
                                <span class="badge bg-danger">Out of Stock</span>
                            @endif
                        </td>
                        <td>
                            @if($saree->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                            @if($saree->is_featured)
                                <span class="badge bg-primary">Featured</span>
                            @endif
                            @if($saree->is_new_arrival)
                                <span class="badge bg-info">New</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.sarees.show', $saree) }}" 
                               class="btn btn-sm btn-info btn-action" 
                               title="View">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.sarees.edit', $saree) }}" 
                               class="btn btn-sm btn-warning btn-action" 
                               title="Edit">
                                <i class="fa fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.sarees.destroy', $saree) }}" 
                                  method="POST" 
                                  class="d-inline"
                                  onsubmit="return confirm('Are you sure you want to delete this saree?')">
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
            {{ $sarees->links() }}
        </div>
        @else
        <div class="text-center py-5">
            <i class="fa fa-shopping-bag fa-3x text-muted mb-3"></i>
            <p class="text-muted">No sarees found. Add your first saree to get started!</p>
            <a href="{{ route('admin.sarees.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> Add New Saree
            </a>
        </div>
        @endif
    </div>
</div>
@endsection