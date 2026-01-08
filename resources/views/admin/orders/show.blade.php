@extends('admin.layouts.app')

@section('title', 'Order Details - ' . $order->order_number)
@section('page-title', 'Order Details')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="mb-3">
            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
                <i class="fa fa-arrow-left"></i> Back to Orders
            </a>
            <a href="{{ route('admin.orders.invoice', $order) }}" 
               class="btn btn-info" 
               target="_blank">
                <i class="fa fa-file-text"></i> View Invoice
            </a>
            @if($order->order_status == 'cancelled')
            <form action="{{ route('admin.orders.destroy', $order) }}" 
                  method="POST" 
                  class="d-inline"
                  onsubmit="return confirm('Are you sure you want to delete this order?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="fa fa-trash"></i> Delete Order
                </button>
            </form>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <!-- Order Information -->
    <div class="col-md-8">
        <!-- Order Items -->
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Order Items</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>SKU</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td>
                                    <strong>{{ $item->saree_name }}</strong><br>
                                    <small class="text-muted">{{ $item->fabric }}</small>
                                </td>
                                <td>{{ $item->saree_sku }}</td>
                                <td>₹{{ number_format($item->price, 2) }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>₹{{ number_format($item->getSubtotal(), 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-end"><strong>Subtotal:</strong></td>
                                <td><strong>₹{{ number_format($order->subtotal, 2) }}</strong></td>
                            </tr>
                            @if($order->discount > 0)
                            <tr>
                                <td colspan="4" class="text-end"><strong>Discount:</strong></td>
                                <td><strong class="text-danger">-₹{{ number_format($order->discount, 2) }}</strong></td>
                            </tr>
                            @endif
                            <tr>
                                <td colspan="4" class="text-end"><strong>Shipping:</strong></td>
                                <td><strong>₹{{ number_format($order->shipping_cost, 2) }}</strong></td>
                            </tr>
                            <tr class="table-primary">
                                <td colspan="4" class="text-end"><strong>Total:</strong></td>
                                <td><strong>₹{{ number_format($order->total, 2) }}</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <!-- Billing Address -->
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Billing Address</h5>
            </div>
            <div class="card-body">
                <p class="mb-1"><strong>{{ $order->first_name }} {{ $order->last_name }}</strong></p>
                <p class="mb-1">{{ $order->street_address }}</p>
                @if($order->apartment)
                <p class="mb-1">{{ $order->apartment }}</p>
                @endif
                <p class="mb-1">{{ $order->city }}, {{ $order->state }} {{ $order->zip }}</p>
                <p class="mb-1">{{ $order->country }}</p>
                <p class="mb-1"><i class="fa fa-envelope"></i> {{ $order->email }}</p>
                <p class="mb-0"><i class="fa fa-phone"></i> {{ $order->phone }}</p>
            </div>
        </div>

        <!-- Shipping Address -->
        @if($order->ship_to_different)
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Shipping Address</h5>
            </div>
            <div class="card-body">
                <p class="mb-1"><strong>{{ $order->shipping_first_name }} {{ $order->shipping_last_name }}</strong></p>
                <p class="mb-1">{{ $order->shipping_street_address }}</p>
                @if($order->shipping_apartment)
                <p class="mb-1">{{ $order->shipping_apartment }}</p>
                @endif
                <p class="mb-1">{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_zip }}</p>
                <p class="mb-0">{{ $order->shipping_country }}</p>
            </div>
        </div>
        @endif

        <!-- Order Notes -->
        @if($order->order_notes)
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Order Notes</h5>
            </div>
            <div class="card-body">
                <p class="mb-0">{{ $order->order_notes }}</p>
            </div>
        </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="col-md-4">
        <!-- Order Summary -->
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Order Summary</h5>
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-6 fw-bold">Order Number:</div>
                    <div class="col-6">{{ $order->order_number }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-6 fw-bold">Date:</div>
                    <div class="col-6">{{ $order->created_at->format('M d, Y H:i') }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-6 fw-bold">Payment Method:</div>
                    <div class="col-6">{{ ucfirst($order->payment_method) }}</div>
                </div>
                @if($order->user)
                <div class="row">
                    <div class="col-6 fw-bold">Customer:</div>
                    <div class="col-6">
                        <a href="#">{{ $order->user->name }}</a>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Update Order Status -->
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Order Status</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group mb-3">
                        <label class="form-label">Current Status:</label>
                        <div>
                            @if($order->order_status == 'pending')
                                <span class="badge bg-warning">Pending</span>
                            @elseif($order->order_status == 'processing')
                                <span class="badge bg-info">Processing</span>
                            @elseif($order->order_status == 'completed')
                                <span class="badge bg-success">Completed</span>
                            @elseif($order->order_status == 'cancelled')
                                <span class="badge bg-danger">Cancelled</span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="order_status" class="form-label">Update Status:</label>
                        <select name="order_status" id="order_status" class="form-control" required>
                            <option value="pending" {{ $order->order_status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ $order->order_status == 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="completed" {{ $order->order_status == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ $order->order_status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="admin_notes" class="form-label">Admin Notes:</label>
                        <textarea name="admin_notes" id="admin_notes" class="form-control" rows="3" placeholder="Optional notes...">{{ $order->admin_notes }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fa fa-save"></i> Update Status
                    </button>
                </form>
            </div>
        </div>

        <!-- Update Payment Status -->
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Payment Status</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.orders.update-payment-status', $order) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group mb-3">
                        <label class="form-label">Current Status:</label>
                        <div>
                            @if($order->payment_status == 'paid')
                                <span class="badge bg-success">Paid</span>
                            @elseif($order->payment_status == 'pending')
                                <span class="badge bg-warning">Pending</span>
                            @elseif($order->payment_status == 'failed')
                                <span class="badge bg-danger">Failed</span>
                            @elseif($order->payment_status == 'refunded')
                                <span class="badge bg-info">Refunded</span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="payment_status" class="form-label">Update Status:</label>
                        <select name="payment_status" id="payment_status" class="form-control" required>
                            <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="failed" {{ $order->payment_status == 'failed' ? 'selected' : '' }}>Failed</option>
                            <option value="refunded" {{ $order->payment_status == 'refunded' ? 'selected' : '' }}>Refunded</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success w-100">
                        <i class="fa fa-money"></i> Update Payment
                    </button>
                </form>
            </div>
        </div>

        <!-- Order Timeline -->
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Order Timeline</h5>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="timeline-item">
                        <small class="text-muted">{{ $order->created_at->format('M d, Y H:i') }}</small>
                        <p class="mb-0"><strong>Order Placed</strong></p>
                    </div>
                    <div class="timeline-item mt-3">
                        <small class="text-muted">{{ $order->updated_at->format('M d, Y H:i') }}</small>
                        <p class="mb-0"><strong>Last Updated</strong></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection