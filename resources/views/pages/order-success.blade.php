@extends('layouts.app')

@section('title', 'Order Success - Saree Shop')

@section('content')
<!--== Start Page Title Area ==-->
<section class="page-title-area bg-img" data-bg-img="{{ asset('assets/img/photos/bg-page1.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-title-content">
                    <h2 class="title">Order Confirmation</h2>
                    <div class="bread-crumbs">
                        <a href="{{ route('home') }}">Home<span class="breadcrumb-sep">></span></a>
                        <span class="active">Order Success</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--== End Page Title Area ==-->

<!--== Start Order Success Area ==-->
<section class="shop-checkout-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <!-- Success Message -->
                <div class="order-success-message text-center mb-5">
                    <div class="success-icon mb-4">
                        <i class="lastudioicon-check-circle" style="font-size: 80px; color: #28a745;"></i>
                    </div>
                    <h2 class="title mb-3">Thank you for your order!</h2>
                    <p class="lead mb-4">Your order has been successfully placed and is being processed.</p>
                    <div class="alert alert-success d-inline-block px-5 py-3">
                        <strong>Order Number:</strong> <span style="font-size: 1.2em;">{{ $order->order_number }}</span>
                    </div>
                    <p class="mt-3">We've sent an order confirmation email to <strong>{{ $order->email }}</strong></p>
                </div>

                <!-- Order Details -->
                <div class="shop-billing-form mb-4">
                    <h4 class="title">Order Details</h4>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="order-info-box">
                                <h5 class="mb-3">Billing Address</h5>
                                <address style="line-height: 1.8;">
                                    <strong>{{ $order->first_name }} {{ $order->last_name }}</strong><br>
                                    {{ $order->street_address }}<br>
                                    @if($order->apartment)
                                        {{ $order->apartment }}<br>
                                    @endif
                                    {{ $order->city }}, {{ $order->state }} {{ $order->zip }}<br>
                                    {{ $order->country }}<br>
                                    <strong>Phone:</strong> {{ $order->phone }}<br>
                                    <strong>Email:</strong> {{ $order->email }}
                                </address>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="order-info-box">
                                @if($order->ship_to_different)
                                <h5 class="mb-3">Shipping Address</h5>
                                <address style="line-height: 1.8;">
                                    <strong>{{ $order->shipping_first_name }} {{ $order->shipping_last_name }}</strong><br>
                                    {{ $order->shipping_street_address }}<br>
                                    @if($order->shipping_apartment)
                                        {{ $order->shipping_apartment }}<br>
                                    @endif
                                    {{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_zip }}<br>
                                    {{ $order->shipping_country }}
                                </address>
                                @else
                                <h5 class="mb-3">Shipping Address</h5>
                                <p><em>Same as billing address</em></p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="order-info-box">
                                <h5 class="mb-3">Payment Method</h5>
                                <p class="mb-0">
                                    @switch($order->payment_method)
                                        @case('cod')
                                            <i class="lastudioicon-e-remove"></i> Cash on Delivery
                                            @break
                                        @case('bank_transfer')
                                            <i class="lastudioicon-e-remove"></i> Direct Bank Transfer
                                            @break
                                        @case('paypal')
                                            <i class="lastudioicon-e-remove"></i> PayPal
                                            @break
                                        @default
                                            {{ ucfirst($order->payment_method) }}
                                    @endswitch
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="order-info-box">
                                <h5 class="mb-3">Order Status</h5>
                                <p class="mb-0">
                                    <span class="badge bg-warning text-dark" style="font-size: 0.9em; padding: 5px 15px;">{{ ucfirst($order->order_status) }}</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    @if($order->order_notes)
                    <div class="row">
                        <div class="col-12 mb-4">
                            <div class="order-info-box">
                                <h5 class="mb-3">Order Notes</h5>
                                <p class="mb-0">{{ $order->order_notes }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Order Items -->
                <h4 class="title">Your Order</h4>
                <div class="order-review-details mb-4">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Fabric</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td>
                                    <span class="product-title">{{ $item->saree_name }}</span><br>
                                    <small class="text-muted">SKU: {{ $item->saree_sku }}</small>
                                </td>
                                <td>{{ ucfirst($item->fabric) }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>₹{{ number_format($item->price, 2) }}</td>
                                <td>₹{{ number_format($item->getSubtotal(), 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="cart-subtotal">
                                <th colspan="4">Subtotal</th>
                                <td>₹{{ number_format($order->subtotal, 2) }}</td>
                            </tr>
                            @if($order->discount > 0)
                            <tr>
                                <th colspan="4">Discount</th>
                                <td class="text-success">-₹{{ number_format($order->discount, 2) }}</td>
                            </tr>
                            @endif
                            <tr class="shipping">
                                <th colspan="4">Shipping</th>
                                <td>₹{{ number_format($order->shipping_cost, 2) }}</td>
                            </tr>
                            <tr class="final-total">
                                <th colspan="4">Total</th>
                                <td><span class="total-amount">₹{{ number_format($order->total, 2) }}</span></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Action Buttons -->
                <div class="text-center mt-5">
                    <a href="{{ route('shop') }}" class="btn btn-theme btn-black me-3">
                        <i class="lastudioicon-arrow-left"></i> Continue Shopping
                    </a>
                    <a href="{{ route('home') }}" class="btn btn-theme">
                        <i class="lastudioicon-home-2"></i> Go to Home
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<!--== End Order Success Area ==-->

@push('styles')
<style>
.order-success-message {
    background: white;
    padding: 50px 30px;
    border-radius: 8px;
    box-shadow: 0 0 20px rgba(0,0,0,0.08);
}

.order-info-box {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 5px;
    height: 100%;
}

.order-info-box h5 {
    font-size: 16px;
    font-weight: 600;
    border-bottom: 2px solid #ddd;
    padding-bottom: 10px;
    margin-bottom: 15px;
}

.order-info-box address {
    margin-bottom: 0;
}

.table thead th {
    background: #f8f9fa;
    font-weight: 600;
    border-bottom: 2px solid #dee2e6;
}

.btn-theme {
    padding: 12px 30px;
    font-size: 14px;
    font-weight: 500;
}

@media (max-width: 768px) {
    .order-success-message {
        padding: 30px 20px;
    }
    
    .btn-theme {
        display: block;
        width: 100%;
        margin-bottom: 10px;
    }
    
    .me-3 {
        margin-right: 0 !important;
    }
}
</style>
@endpush
@endsection