@extends('admin.layouts.app')

@section('title', 'Manage Orders')
@section('page-title', 'Manage Orders')

@section('content')
<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-2">
        <div class="card text-center">
            <div class="card-body">
                <h3>{{ $stats['total'] }}</h3>
                <p class="text-muted mb-0">Total Orders</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-warning">{{ $stats['pending'] }}</h3>
                <p class="text-muted mb-0">Pending</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-info">{{ $stats['processing'] }}</h3>
                <p class="text-muted mb-0">Processing</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-success">{{ $stats['completed'] }}</h3>
                <p class="text-muted mb-0">Completed</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-danger">{{ $stats['cancelled'] }}</h3>
                <p class="text-muted mb-0">Cancelled</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-primary">₹{{ number_format($stats['total_revenue'], 2) }}</h3>
                <p class="text-muted mb-0">Revenue</p>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.orders.index') }}">
            <div class="row">
                <div class="col-md-3">
                    <input type="text" 
                           name="search" 
                           class="form-control" 
                           placeholder="Search order, email, name..." 
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-control">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="payment_status" class="form-control">
                        <option value="">Payment Status</option>
                        <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>Failed</option>
                        <option value="refunded" {{ request('payment_status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                </div>
                <div class="col-md-2">
                    <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fa fa-filter"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Orders Table -->
<div class="card">
    <div class="card-header bg-white">
        <h5 class="mb-0">All Orders</h5>
    </div>
    <div class="card-body">
        @if($orders->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Date</th>
                        <th>Customer</th>
                        <th>Items</th>
                        <th>Total</th>
                        <th>Payment</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>
                            <strong>{{ $order->order_number }}</strong>
                        </td>
                        <td>
                            <small>{{ $order->created_at->format('M d, Y') }}</small><br>
                            <small class="text-muted">{{ $order->created_at->format('h:i A') }}</small>
                        </td>
                        <td>
                            <strong>{{ $order->first_name }} {{ $order->last_name }}</strong><br>
                            <small class="text-muted">{{ $order->email }}</small>
                        </td>
                        <td>
                            <span class="badge bg-secondary">{{ $order->items->count() }} items</span>
                        </td>
                        <td>
                            <strong>₹{{ number_format($order->total, 2) }}</strong>
                        </td>
                        <td>
                            @if($order->payment_status == 'paid')
                                <span class="badge bg-success">Paid</span>
                            @elseif($order->payment_status == 'pending')
                                <span class="badge bg-warning">Pending</span>
                            @elseif($order->payment_status == 'failed')
                                <span class="badge bg-danger">Failed</span>
                            @else
                                <span class="badge bg-info">{{ ucfirst($order->payment_status) }}</span>
                            @endif
                            <br>
                            <small class="text-muted">{{ ucfirst($order->payment_method) }}</small>
                        </td>
                        <td>
                            @if($order->order_status == 'pending')
                                <span class="badge bg-warning">Pending</span>
                            @elseif($order->order_status == 'processing')
                                <span class="badge bg-info">Processing</span>
                            @elseif($order->order_status == 'completed')
                                <span class="badge bg-success">Completed</span>
                            @elseif($order->order_status == 'cancelled')
                                <span class="badge bg-danger">Cancelled</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order) }}" 
                               class="btn btn-sm btn-info btn-action" 
                               title="View Details">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.orders.invoice', $order) }}" 
                               class="btn btn-sm btn-secondary btn-action" 
                               title="Invoice"
                               target="_blank">
                                <i class="fa fa-file-text"></i>
                            </a>
                            @if($order->order_status == 'cancelled')
                            <form action="{{ route('admin.orders.destroy', $order) }}" 
                                  method="POST" 
                                  class="d-inline"
                                  onsubmit="return confirm('Are you sure you want to delete this order?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="btn btn-sm btn-danger btn-action" 
                                        title="Delete">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $orders->links() }}
        </div>
        @else
        <div class="text-center py-5">
            <i class="fa fa-shopping-cart fa-3x text-muted mb-3"></i>
            <p class="text-muted">No orders found.</p>
        </div>
        @endif
    </div>
</div>
@endsection