@extends('layouts.app')

@section('title', 'My Orders - Saree Shop')

@section('content')
<!--== Start Page Title Area ==-->
<section class="page-title-area bg-img" data-bg-img="{{ asset('assets/img/photos/bg-page3.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-title-content">
                    <h2 class="title">My Orders</h2>
                    <div class="bread-crumbs">
                        <a href="{{ url('/') }}">Home<span class="breadcrumb-sep">></span></a>
                        <span class="active">My Orders</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--== End Page Title Area ==-->

<!--== Start Orders Section ==-->
<section class="cart-area ptb-100">
    <div class="container">
        @if($orders->count() > 0)
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <!-- Orders Grid -->
                    <div class="orders-grid">
                        @foreach($orders as $order)
                        <div class="order-card">
                            <div class="order-card-header">
                                <div class="order-info">
                                    <h4 class="order-number">{{ $order->order_number }}</h4>
                                    <p class="order-date">
                                        <i class="lastudioicon-calendar"></i> 
                                        {{ $order->created_at->format('F d, Y') }}
                                    </p>
                                </div>
                                <div class="order-status-badge">
                                    <span class="badge 
                                        @if($order->order_status === 'completed') badge-success
                                        @elseif($order->order_status === 'processing') badge-info
                                        @elseif($order->order_status === 'pending') badge-warning
                                        @elseif($order->order_status === 'cancelled') badge-danger
                                        @else badge-secondary
                                        @endif">
                                        {{ ucfirst($order->order_status) }}
                                    </span>
                                </div>
                            </div>

                            <div class="order-card-body">
                                <div class="order-items-preview">
                                    @foreach($order->items->take(3) as $item)
                                    <div class="order-item-thumb">
                                        @if($item->saree && $item->saree->featured_image)
                                            <img src="{{ asset($item->saree->featured_image) }}" 
                                                 alt="{{ $item->saree_name }}">
                                        @else
                                            <img src="{{ asset('assets/img/photos/bg-page3.jpg') }}" alt="Product">
                                        @endif
                                    </div>
                                    @endforeach
                                    
                                    @if($order->items->count() > 3)
                                    <div class="order-item-more">
                                        +{{ $order->items->count() - 3 }}
                                    </div>
                                    @endif
                                </div>

                                <div class="order-summary-info">
                                    <div class="info-row">
                                        <span class="info-label">Items:</span>
                                        <span class="info-value">{{ $order->items->count() }} item(s)</span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Payment:</span>
                                        <span class="info-value">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</span>
                                    </div>
                                    <div class="info-row total-row">
                                        <span class="info-label">Total:</span>
                                        <span class="info-value total-amount">₹{{ number_format($order->total, 2) }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="order-card-footer">
                                <a href="{{ route('orders.show', $order->order_number) }}" class="btn btn-theme">
                                    View Order Details
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="pagination-area text-center mt-5">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="empty-orders-state">
                        <div class="empty-icon">
                            <i class="lastudioicon-shopping-bag"></i>
                        </div>
                        <h3>No Orders Yet</h3>
                        <p>You haven't placed any orders yet. Start shopping to see your orders here!</p>
                        <a href="{{ route('shop') }}" class="btn btn-theme">
                            <i class="lastudioicon-shopping-bag"></i> Start Shopping
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
<!--== End Orders Section ==-->

@push('styles')
<style>
/* Orders Grid Layout */
.orders-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 25px;
    margin-bottom: 30px;
}

@media (max-width: 768px) {
    .orders-grid {
        grid-template-columns: 1fr;
    }
}

/* Order Card */
.order-card {
    background: #ffffff;
    border-radius: 8px;
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 0 20px rgba(0,0,0,0.08);
}

.order-card:hover {
    box-shadow: 0 5px 25px rgba(0, 0, 0, 0.15);
    transform: translateY(-5px);
}

/* Order Card Header */
.order-card-header {
    padding: 20px;
    background: #f8f9fa;
    border-bottom: 1px solid #e8e8e8;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
}

.order-info h4.order-number {
    font-size: 18px;
    font-weight: 700;
    color: #333;
    margin: 0 0 8px 0;
}

.order-date {
    font-size: 13px;
    color: #666;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 5px;
}

.order-date i {
    color: #999;
    font-size: 14px;
}

/* Status Badge */
.badge {
    padding: 6px 14px;
    font-size: 11px;
    font-weight: 600;
    border-radius: 20px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.badge-success { 
    background-color: #28a745;
    color: white; 
}

.badge-info { 
    background-color: #17a2b8;
    color: white; 
}

.badge-warning { 
    background-color: #ffc107;
    color: #212529; 
}

.badge-danger { 
    background-color: #dc3545;
    color: white; 
}

.badge-secondary { 
    background-color: #6c757d;
    color: white; 
}

/* Order Card Body */
.order-card-body {
    padding: 20px;
}

/* Order Items Preview */
.order-items-preview {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}

.order-item-thumb {
    width: 70px;
    height: 70px;
    border-radius: 6px;
    overflow: hidden;
    border: 2px solid #f0f0f0;
}

.order-item-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.order-item-more {
    width: 70px;
    height: 70px;
    border-radius: 6px;
    background: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    color: #666;
    border: 2px dashed #ddd;
}

/* Order Summary Info */
.order-summary-info {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 6px;
}

.info-row {
    display: flex;
    justify-content: space-between;
    padding: 8px 0;
    border-bottom: 1px solid #e8e8e8;
}

.info-row:last-child {
    border-bottom: none;
}

.info-label {
    font-size: 14px;
    color: #666;
    font-weight: 500;
}

.info-value {
    font-size: 14px;
    color: #333;
    font-weight: 600;
}

.total-row {
    margin-top: 5px;
    padding-top: 15px;
    border-top: 2px solid #ddd;
}

.total-amount {
    font-size: 18px;
    color: #000;
}

/* Order Card Footer */
.order-card-footer {
    padding: 15px 20px;
    background: #fff;
    border-top: 1px solid #e8e8e8;
}

.order-card-footer .btn-theme {
    width: 100%;
    text-align: center;
    padding: 12px;
    font-size: 14px;
    font-weight: 600;
    display: block;
}

/* Empty State */
.empty-orders-state {
    text-align: center;
    padding: 80px 20px;
    background: white;
    border-radius: 8px;
    box-shadow: 0 0 20px rgba(0,0,0,0.08);
}

.empty-icon {
    margin-bottom: 25px;
}

.empty-icon i {
    font-size: 80px;
    color: #ddd;
}

.empty-orders-state h3 {
    font-size: 28px;
    color: #333;
    margin-bottom: 15px;
    font-weight: 700;
}

.empty-orders-state p {
    font-size: 16px;
    color: #666;
    margin-bottom: 30px;
    max-width: 500px;
    margin-left: auto;
    margin-right: auto;
    line-height: 1.6;
}

.empty-orders-state .btn-theme {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 14px 35px;
}

/* Responsive */
@media (max-width: 576px) {
    .order-card-header {
        flex-direction: column;
        gap: 15px;
    }
    
    .order-status-badge {
        align-self: flex-start;
    }
    
    .orders-grid {
        gap: 20px;
    }
}
</style>
@endpush
@endsection