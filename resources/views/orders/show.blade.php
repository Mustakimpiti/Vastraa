@extends('layouts.app')

@section('title', 'Order Details - Saree Shop')

@section('content')
<!--== Start Page Title Area ==-->
<section class="page-title-area bg-img" data-bg-img="{{ asset('assets/img/photos/bg-page3.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-title-content">
                    <h2 class="title">Order Details</h2>
                    <div class="bread-crumbs">
                        <a href="{{ url('/') }}">Home<span class="breadcrumb-sep">></span></a>
                        <a href="{{ route('orders.index') }}">My Orders<span class="breadcrumb-sep">></span></a>
                        <span class="active">{{ $order->order_number }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--== End Page Title Area ==-->

<!--== Start Order Details Area ==-->
<section class="shop-checkout-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <!-- Order Header -->
                <div class="order-header-card mb-4">
                    <div class="row align-items-center">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <h3 class="order-number mb-2">Order #{{ $order->order_number }}</h3>
                            <p class="order-date mb-0">
                                <i class="lastudioicon-calendar"></i> 
                                Placed on {{ $order->created_at->format('F d, Y \a\t h:i A') }}
                            </p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <div class="status-badges">
                                <div class="mb-2">
                                    <span class="status-label">Order Status:</span>
                                    <span class="badge-status 
                                        @if($order->order_status === 'completed') badge-completed
                                        @elseif($order->order_status === 'processing') badge-processing
                                        @elseif($order->order_status === 'pending') badge-pending
                                        @elseif($order->order_status === 'cancelled') badge-cancelled
                                        @else badge-default
                                        @endif">
                                        {{ ucfirst($order->order_status) }}
                                    </span>
                                </div>
                                <div>
                                    <span class="status-label">Payment:</span>
                                    <span class="badge-status 
                                        @if($order->payment_status === 'paid') badge-completed
                                        @elseif($order->payment_status === 'pending') badge-pending
                                        @else badge-cancelled
                                        @endif">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="shop-billing-form mb-4">
                    <h4 class="title">
                        <i class="lastudioicon-shopping-bag"></i> Order Items
                    </h4>
                    <div class="order-items-list">
                        @foreach($order->items as $item)
                        <div class="order-item-row">
                            <div class="item-image-wrapper">
                                @if($item->saree && $item->saree->featured_image)
                                    <a href="{{ route('product.show', $item->saree->slug) }}">
                                        <img src="{{ asset($item->saree->featured_image) }}" 
                                             alt="{{ $item->saree_name }}"
                                             class="item-thumbnail">
                                    </a>
                                @else
                                    <img src="{{ asset('assets/img/photos/bg-page3.jpg') }}" 
                                         alt="Product"
                                         class="item-thumbnail">
                                @endif
                            </div>
                            
                            <div class="item-info-wrapper">
                                <h5 class="item-title">
                                    @if($item->saree)
                                        <a href="{{ route('product.show', $item->saree->slug) }}">
                                            {{ $item->saree_name }}
                                        </a>
                                    @else
                                        {{ $item->saree_name }}
                                    @endif
                                </h5>
                                <div class="item-metadata">
                                    <span class="meta-item"><strong>SKU:</strong> {{ $item->saree_sku }}</span>
                                    <span class="meta-item"><strong>Fabric:</strong> {{ $item->fabric }}</span>
                                </div>
                                <div class="item-price-details">
                                    <span class="unit-price">₹{{ number_format($item->price, 2) }}</span>
                                    <span class="quantity-sep">×</span>
                                    <span class="quantity-value">{{ $item->quantity }}</span>
                                    <span class="equals-sep">=</span>
                                    <span class="subtotal-price">₹{{ number_format($item->getSubtotal(), 2) }}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Order Information Grid -->
                <div class="row">
                    <!-- Billing Address -->
                    <div class="col-md-6 mb-4">
                        <div class="info-card-box">
                            <h5 class="info-card-title">
                                <i class="lastudioicon-pin-3-2"></i> Billing Address
                            </h5>
                            <div class="info-card-content">
                                <p class="recipient-name">{{ $order->first_name }} {{ $order->last_name }}</p>
                                <address class="address-lines">
                                    {{ $order->street_address }}<br>
                                    @if($order->apartment)
                                        {{ $order->apartment }}<br>
                                    @endif
                                    {{ $order->city }}, {{ $order->state }} {{ $order->zip }}<br>
                                    {{ $order->country }}
                                </address>
                                <div class="contact-details">
                                    <p><i class="lastudioicon-phone"></i> {{ $order->phone }}</p>
                                    <p><i class="lastudioicon-envelope"></i> {{ $order->email }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Address -->
                    <div class="col-md-6 mb-4">
                        <div class="info-card-box">
                            @if($order->ship_to_different)
                                <h5 class="info-card-title">
                                    <i class="lastudioicon-truck"></i> Shipping Address
                                </h5>
                                <div class="info-card-content">
                                    <p class="recipient-name">{{ $order->shipping_first_name }} {{ $order->shipping_last_name }}</p>
                                    <address class="address-lines">
                                        {{ $order->shipping_street_address }}<br>
                                        @if($order->shipping_apartment)
                                            {{ $order->shipping_apartment }}<br>
                                        @endif
                                        {{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_zip }}<br>
                                        {{ $order->shipping_country }}
                                    </address>
                                </div>
                            @else
                                <h5 class="info-card-title">
                                    <i class="lastudioicon-truck"></i> Shipping Address
                                </h5>
                                <div class="info-card-content">
                                    <p class="same-address-note"><em>Same as billing address</em></p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="col-md-6 mb-4">
                        <div class="info-card-box">
                            <h5 class="info-card-title">
                                <i class="lastudioicon-credit-card"></i> Payment Method
                            </h5>
                            <div class="info-card-content">
                                <p class="payment-method-name">
                                    {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Order Notes -->
                    @if($order->order_notes)
                    <div class="col-md-6 mb-4">
                        <div class="info-card-box">
                            <h5 class="info-card-title">
                                <i class="lastudioicon-comment"></i> Order Notes
                            </h5>
                            <div class="info-card-content">
                                <p class="notes-text">{{ $order->order_notes }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Order Summary -->
                <div class="shop-billing-form mb-4">
                    <h4 class="title">
                        <i class="lastudioicon-file-text"></i> Order Summary
                    </h4>
                    <div class="order-summary-table">
                        <table class="table">
                            <tbody>
                                <tr class="summary-subtotal">
                                    <td>Subtotal</td>
                                    <td class="text-end">₹{{ number_format($order->subtotal, 2) }}</td>
                                </tr>
                                @if($order->discount > 0)
                                <tr class="summary-discount">
                                    <td>Discount</td>
                                    <td class="text-end text-success">-₹{{ number_format($order->discount, 2) }}</td>
                                </tr>
                                @endif
                                <tr class="summary-shipping">
                                    <td>Shipping</td>
                                    <td class="text-end">₹{{ number_format($order->shipping_cost, 2) }}</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr class="summary-total">
                                    <th>Total</th>
                                    <th class="text-end">₹{{ number_format($order->total, 2) }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="text-center mt-5">
                    <a href="{{ route('orders.index') }}" class="btn btn-theme btn-black">
                        <i class="lastudioicon-arrow-left"></i> Back to Orders
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<!--== End Order Details Area ==-->

@push('styles')
<style>
/* Order Header Card */
.order-header-card {
    background: white;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 0 20px rgba(0,0,0,0.08);
}

.order-number {
    font-size: 24px;
    font-weight: 600;
    color: #333;
    margin-bottom: 8px;
}

.order-date {
    color: #666;
    font-size: 14px;
}

.order-date i {
    margin-right: 6px;
    color: #999;
}

/* Status Badges */
.status-badges {
    display: inline-block;
}

.status-label {
    font-size: 13px;
    color: #666;
    margin-right: 8px;
}

.badge-status {
    display: inline-block;
    padding: 6px 16px;
    font-size: 12px;
    font-weight: 600;
    border-radius: 20px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.badge-completed {
    background-color: #28a745;
    color: white;
}

.badge-processing {
    background-color: #17a2b8;
    color: white;
}

.badge-pending {
    background-color: #ffc107;
    color: #212529;
}

.badge-cancelled {
    background-color: #dc3545;
    color: white;
}

.badge-default {
    background-color: #6c757d;
    color: white;
}

/* Shop Billing Form Override */
.shop-billing-form {
    background: white;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 0 20px rgba(0,0,0,0.08);
}

.shop-billing-form .title {
    font-size: 18px;
    font-weight: 600;
    color: #333;
    margin-bottom: 25px;
    padding-bottom: 15px;
    border-bottom: 2px solid #f0f0f0;
    display: flex;
    align-items: center;
    gap: 10px;
}

.shop-billing-form .title i {
    font-size: 20px;
    color: #666;
}

/* Order Items List */
.order-items-list {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.order-item-row {
    display: flex;
    gap: 20px;
    padding: 20px;
    background: #f8f9fa;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.order-item-row:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    transform: translateY(-2px);
}

.item-image-wrapper {
    flex-shrink: 0;
}

.item-thumbnail {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 6px;
    border: 2px solid #e0e0e0;
}

.item-info-wrapper {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.item-title {
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 10px;
}

.item-title a {
    color: #333;
    text-decoration: none;
    transition: color 0.3s;
}

.item-title a:hover {
    color: #000;
}

.item-metadata {
    display: flex;
    gap: 20px;
    margin-bottom: 12px;
    font-size: 13px;
    color: #666;
}

.meta-item {
    white-space: nowrap;
}

.item-price-details {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 15px;
    font-weight: 600;
}

.unit-price {
    color: #333;
}

.quantity-sep, .equals-sep {
    color: #999;
    font-weight: 400;
}

.quantity-value {
    color: #666;
}

.subtotal-price {
    color: #000;
    font-size: 16px;
}

/* Info Card Box */
.info-card-box {
    background: #f8f9fa;
    padding: 25px;
    border-radius: 8px;
    height: 100%;
}

.info-card-title {
    font-size: 16px;
    font-weight: 600;
    color: #333;
    margin-bottom: 20px;
    padding-bottom: 12px;
    border-bottom: 2px solid #e0e0e0;
    display: flex;
    align-items: center;
    gap: 8px;
}

.info-card-title i {
    font-size: 18px;
    color: #666;
}

.info-card-content {
    line-height: 1.8;
}

.recipient-name {
    font-size: 15px;
    font-weight: 600;
    color: #333;
    margin-bottom: 12px;
}

.address-lines {
    font-size: 14px;
    color: #666;
    margin-bottom: 15px;
    font-style: normal;
}

.contact-details p {
    font-size: 14px;
    color: #666;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.contact-details i {
    color: #999;
    font-size: 14px;
}

.same-address-note {
    font-size: 14px;
    color: #999;
    margin: 0;
}

.payment-method-name {
    font-size: 14px;
    color: #666;
    margin: 0;
}

.notes-text {
    font-size: 14px;
    color: #666;
    margin: 0;
    line-height: 1.8;
}

/* Order Summary Table */
.order-summary-table {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
}

.order-summary-table .table {
    margin-bottom: 0;
}

.order-summary-table tbody tr td {
    padding: 12px 0;
    border-bottom: 1px solid #e0e0e0;
    font-size: 15px;
}

.order-summary-table tbody tr:last-child td {
    border-bottom: none;
}

.order-summary-table tfoot tr {
    border-top: 2px solid #333;
}

.order-summary-table tfoot th {
    padding: 15px 0;
    font-size: 18px;
    font-weight: 700;
    color: #333;
}

/* Button Styles */
.btn-theme {
    padding: 14px 35px;
    font-size: 14px;
    font-weight: 500;
    border-radius: 4px;
    transition: all 0.3s;
}

.btn-theme i {
    margin-right: 8px;
}

/* Responsive */
@media (max-width: 768px) {
    .order-header-card {
        padding: 20px;
    }
    
    .order-number {
        font-size: 20px;
    }
    
    .status-badges {
        display: block;
        margin-top: 15px;
    }
    
    .status-badges > div {
        margin-bottom: 10px;
    }
    
    .shop-billing-form {
        padding: 20px;
    }
    
    .order-item-row {
        flex-direction: column;
        padding: 15px;
    }
    
    .item-thumbnail {
        width: 100%;
        height: 200px;
    }
    
    .item-metadata {
        flex-direction: column;
        gap: 8px;
    }
    
    .item-price-details {
        flex-wrap: wrap;
    }
    
    .info-card-box {
        padding: 20px;
    }
    
    .btn-theme {
        display: block;
        width: 100%;
    }
}
</style>
@endpush
@endsection