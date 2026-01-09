@extends('layouts.app')

@section('title', 'My Account - Artfauj')

@section('content')
<!--== Start Page Title Area ==-->
<section class="page-title-area bg-img" data-bg-img="{{ asset('assets/img/photos/bg-page3.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-title-content">
                    <h2 class="title">My Account</h2>
                    <div class="bread-crumbs">
                        <a href="{{ url('/') }}">Home<span class="breadcrumb-sep">></span></a>
                        <span class="active">My Account</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--== End Page Title Area ==-->

<!--== Start Account Section ==-->
<section class="contact-area">
    <div class="container">
        <!-- Success Message -->
        @if(session('success'))
        <div class="row">
            <div class="col-12">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        </div>
        @endif

        <!-- Error Message -->
        @if(session('error'))
        <div class="row">
            <div class="col-12">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fa fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        </div>
        @endif

        <!-- Validation Errors -->
        @if($errors->any())
        <div class="row">
            <div class="col-12">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        </div>
        @endif

        <div class="row">
            <!-- Main Content -->
            <div class="col-12">
                <!-- Account Overview -->
                <div class="section-title">
                    <h2 class="title">Account Overview</h2>
                </div>

                <div class="row mb-5">
                    <!-- Total Orders -->
                    <div class="col-md-3 mb-4 mb-md-0">
                        <div class="contact-info-wrapper text-center">
                            <div class="contact-info-item">
                                <div class="icon">
                                    <i class="lastudioicon-shopping-bag"></i>
                                </div>
                                <div class="content">
                                    <h4>{{ $totalOrders }}</h4>
                                    <p>Total Orders</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Spent -->
                    <div class="col-md-3 mb-4 mb-md-0">
                        <div class="contact-info-wrapper text-center">
                            <div class="contact-info-item">
                                <div class="icon">
                                    <i class="lastudioicon-wallet"></i>
                                </div>
                                <div class="content">
                                    <h4>₹{{ number_format($totalSpent, 2) }}</h4>
                                    <p>Total Spent</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Saved Addresses -->
                    <div class="col-md-3 mb-4 mb-md-0">
                        <a href="{{ route('addresses.index') }}" class="text-decoration-none">
                            <div class="contact-info-wrapper text-center hover-effect">
                                <div class="contact-info-item">
                                    <div class="icon">
                                        <i class="lastudioicon-pin-3-2"></i>
                                    </div>
                                    <div class="content">
                                        <h4>{{ Auth::user()->addresses()->count() }}</h4>
                                        <p>Saved Addresses</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Member Since -->
                    <div class="col-md-3">
                        <div class="contact-info-wrapper text-center">
                            <div class="contact-info-item">
                                <div class="icon">
                                    <i class="lastudioicon-calendar"></i>
                                </div>
                                <div class="content">
                                    <h4>{{ Auth::user()->created_at ? Auth::user()->created_at->format('M Y') : 'N/A' }}</h4>
                                    <p>Member Since</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="row mb-5">
                    <div class="col-12">
                        <div class="section-title">
                            <h2 class="title">Quick Links</h2>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="{{ route('orders.index') }}" class="quick-link-card">
                            <div class="d-flex align-items-center">
                                <div class="quick-link-icon">
                                    <i class="lastudioicon-shopping-bag"></i>
                                </div>
                                <div class="quick-link-content">
                                    <h5>My Orders</h5>
                                    <p>View and track your orders</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="{{ route('addresses.index') }}" class="quick-link-card">
                            <div class="d-flex align-items-center">
                                <div class="quick-link-icon">
                                    <i class="lastudioicon-pin-3-2"></i>
                                </div>
                                <div class="quick-link-content">
                                    <h5>My Addresses</h5>
                                    <p>Manage your saved addresses</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="#account-details" class="quick-link-card">
                            <div class="d-flex align-items-center">
                                <div class="quick-link-icon">
                                    <i class="lastudioicon-single-01-2"></i>
                                </div>
                                <div class="quick-link-content">
                                    <h5>Account Details</h5>
                                    <p>Update your information</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Recent Orders -->
                @if($recentOrders->count() > 0)
                <div class="mb-5">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="section-title mb-0">
                            <h2 class="title mb-0">Recent Orders</h2>
                        </div>
                        <a href="{{ route('orders.index') }}" class="btn btn-theme btn-sm">View All Orders</a>
                    </div>

                    <div class="table-responsive">
                        <table class="table shop-cart-table text-center">
                            <thead>
                                <tr>
                                    <th class="product-name text-center">Order Number</th>
                                    <th class="product-price text-center">Date</th>
                                    <th class="product-subtotal text-center">Status</th>
                                    <th class="product-subtotal text-center">Total</th>
                                    <th class="product-remove text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody class="cart-items">
                                @foreach($recentOrders as $order)
                                <tr class="cart-item">
                                    <td class="product-name text-center align-middle">
                                        <span class="product-title">{{ $order->order_number }}</span>
                                    </td>
                                    <td class="product-price text-center align-middle">
                                        <span class="price">{{ $order->created_at->format('M d, Y') }}</span>
                                    </td>
                                    <td class="product-subtotal text-center align-middle">
                                        <span class="badge text-uppercase
                                            @if($order->order_status === 'completed') bg-success
                                            @elseif($order->order_status === 'processing') bg-info
                                            @elseif($order->order_status === 'pending') bg-warning text-dark
                                            @elseif($order->order_status === 'cancelled') bg-danger
                                            @endif">
                                            {{ ucfirst($order->order_status) }}
                                        </span>
                                    </td>
                                    <td class="product-subtotal text-center align-middle">
                                        <span class="price amount">₹{{ number_format($order->total, 2) }}</span>
                                    </td>
                                    <td class="product-remove text-center align-middle">
                                        <a href="{{ route('orders.show', $order->order_number) }}" class="btn btn-theme btn-black btn-sm">View Details</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif

                <!-- Account Details Form -->
                <div class="contact-form" id="account-details">
                    <form class="contact-form-wrapper form-style" action="{{ route('account.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="section-title">
                                    <h2 class="title">Account Details</h2>
                                    <p class="subtitle">Update your personal information</p>
                                </div>
                            </div>

                            <!-- Name -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input class="form-control" 
                                           type="text" 
                                           name="name" 
                                           id="name"
                                           placeholder="Full Name*" 
                                           value="{{ old('name', Auth::user()->name) }}" 
                                           required>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input class="form-control" 
                                        type="email" 
                                        name="email" 
                                        id="email"
                                        placeholder="Email Address*" 
                                        value="{{ old('email', Auth::user()->email) }}" 
                                        readonly
                                        required>
                                </div>
                            </div>

                            <!-- Password Section Title -->
                            <div class="col-12 mt-4">
                                <div class="section-title">
                                    <h2 class="title h5">Change Password</h2>
                                    <p class="subtitle">Leave blank to keep current password</p>
                                </div>
                            </div>

                            <!-- Current Password -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input class="form-control" 
                                           type="password" 
                                           name="current_password" 
                                           id="current_password"
                                           placeholder="Current Password">
                                </div>
                            </div>

                            <!-- New Password -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input class="form-control" 
                                           type="password" 
                                           name="new_password" 
                                           id="new_password"
                                           placeholder="New Password">
                                </div>
                            </div>

                            <!-- Confirm New Password -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input class="form-control" 
                                           type="password" 
                                           name="new_password_confirmation" 
                                           id="new_password_confirmation"
                                           placeholder="Confirm New Password">
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="col-md-12">
                                <div class="form-group mb-0">
                                    <button class="btn btn-theme btn-black" type="submit">
                                        Update Account
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!--== End Account Section ==-->

<style>
/* Quick Links Styling */
.quick-link-card {
    display: block;
    padding: 20px;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    text-decoration: none;
    transition: all 0.3s ease;
    background: #fff;
}

.quick-link-card:hover {
    border-color: #3b82f6;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.1);
    transform: translateY(-2px);
}

.quick-link-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: #f3f4f6;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
    font-size: 24px;
    color: #3b82f6;
    transition: all 0.3s ease;
}

.quick-link-card:hover .quick-link-icon {
    background: #3b82f6;
    color: #fff;
}

.quick-link-content h5 {
    margin: 0 0 5px 0;
    font-size: 16px;
    font-weight: 600;
    color: #1f2937;
}

.quick-link-content p {
    margin: 0;
    font-size: 13px;
    color: #6b7280;
}

/* Hover effect for saved addresses card */
.hover-effect {
    transition: all 0.3s ease;
    cursor: pointer;
}

.hover-effect:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

/* Smooth scroll */
html {
    scroll-behavior: smooth;
}
</style>
@endsection