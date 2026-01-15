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

        <!-- Account Overview Stats -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="section-title mb-4">
                    <h2 class="title" style="color: #FF8C42;">Account Overview</h2>
                </div>
            </div>

            <!-- Total Orders -->
            <div class="col-md-3 mb-4">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-bag-check"></i>
                    </div>
                    <div class="stat-content">
                        <h3>{{ $totalOrders }}</h3>
                        <p>Total Orders</p>
                    </div>
                </div>
            </div>

            <!-- Total Spent -->
            <div class="col-md-3 mb-4">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-wallet2"></i>
                    </div>
                    <div class="stat-content">
                        <h3>₹{{ number_format($totalSpent, 2) }}</h3>
                        <p>Total Spent</p>
                    </div>
                </div>
            </div>

            <!-- Saved Addresses -->
            <div class="col-md-3 mb-4">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-geo-alt"></i>
                    </div>
                    <div class="stat-content">
                        <h3>{{ Auth::user()->addresses()->count() }}</h3>
                        <p>Saved Addresses</p>
                    </div>
                </div>
            </div>

            <!-- Member Since -->
            <div class="col-md-3 mb-4">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-calendar-event"></i>
                    </div>
                    <div class="stat-content">
                        <h3>{{ Auth::user()->created_at ? Auth::user()->created_at->format('M Y') : 'N/A' }}</h3>
                        <p>Member Since</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Action Cards -->
        <div class="row">
            <div class="col-12">
                <div class="section-title mb-4">
                    <h2 class="title" style="color: #FF8C42;">Manage Your Account</h2>
                </div>
            </div>

            <!-- My Orders Card -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="action-card" onclick="toggleSection('orders-section')">
                    <div class="action-card-header">
                        <div class="action-icon">
                            <i class="bi bi-bag-check"></i>
                        </div>
                        <div class="action-info">
                            <h4>My Orders</h4>
                            <p>View and track your orders</p>
                        </div>
                        <div class="action-arrow">
                            <i class="bi bi-chevron-down" id="orders-arrow"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- My Addresses Card -->
            <div class="col-lg-4 col-md-6 mb-4">
                <a href="{{ route('addresses.index') }}" class="action-card-link">
                    <div class="action-card">
                        <div class="action-card-header">
                            <div class="action-icon action-icon-teal">
                                <i class="bi bi-geo-alt"></i>
                            </div>
                            <div class="action-info">
                                <h4>My Addresses</h4>
                                <p>Manage delivery addresses</p>
                            </div>
                            <div class="action-arrow">
                                <i class="bi bi-chevron-right"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Account Details Card -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="action-card" onclick="toggleSection('details-section')">
                    <div class="action-card-header">
                        <div class="action-icon">
                            <i class="bi bi-person-circle"></i>
                        </div>
                        <div class="action-info">
                            <h4>Account Details</h4>
                            <p>Update your information</p>
                        </div>
                        <div class="action-arrow">
                            <i class="bi bi-chevron-down" id="details-arrow"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders Section (Collapsible) -->
        <div class="row section-content" id="orders-section" style="display: none;">
            <div class="col-12">
                <div class="content-card">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="mb-0">Recent Orders</h3>
                        <a href="{{ route('orders.index') }}" class="btn btn-theme btn-sm">View All Orders</a>
                    </div>

                    @if($recentOrders->count() > 0)
                    <div class="table-responsive">
                        <table class="table shop-cart-table text-center">
                            <thead>
                                <tr>
                                    <th class="text-start">Order Number</th>
                                    <th class="text-center">Date</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Total</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentOrders as $order)
                                <tr>
                                    <td class="text-start align-middle">
                                        <strong>{{ $order->order_number }}</strong>
                                    </td>
                                    <td class="text-center align-middle">
                                        {{ $order->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="text-center align-middle">
                                        <span class="badge text-uppercase
                                            @if($order->order_status === 'completed') bg-success
                                            @elseif($order->order_status === 'processing') bg-info
                                            @elseif($order->order_status === 'pending') bg-warning text-dark
                                            @elseif($order->order_status === 'cancelled') bg-danger
                                            @endif">
                                            {{ ucfirst($order->order_status) }}
                                        </span>
                                    </td>
                                    <td class="text-center align-middle">
                                        <strong>₹{{ number_format($order->total, 2) }}</strong>
                                    </td>
                                    <td class="text-center align-middle">
                                        <a href="{{ route('orders.show', $order->order_number) }}" class="btn btn-theme btn-black btn-sm">
                                            View Details
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-5">
                        <i class="bi bi-bag-x" style="font-size: 48px; color: #ccc;"></i>
                        <p class="mt-3 text-muted">No orders yet</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Account Details Section (Collapsible) -->
        <div class="row section-content" id="details-section" style="display: none;">
            <div class="col-12">
                <div class="content-card">
                    <h3 class="mb-4">Update Account Details</h3>
                    
                    <form action="{{ route('account.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Name -->
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Full Name *</label>
                                <input class="form-control" 
                                       type="text" 
                                       name="name" 
                                       id="name"
                                       value="{{ old('name', Auth::user()->name) }}" 
                                       required>
                            </div>

                            <!-- Email -->
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email Address *</label>
                                <input class="form-control" 
                                    type="email" 
                                    name="email" 
                                    id="email"
                                    value="{{ old('email', Auth::user()->email) }}" 
                                    readonly
                                    required>
                                <small class="text-muted">Email cannot be changed</small>
                            </div>

                            <!-- Password Section -->
                            <div class="col-12 mt-3 mb-3">
                                <h5>Change Password (Optional)</h5>
                                <p class="text-muted small">Leave blank to keep your current password</p>
                            </div>

                            <!-- Current Password -->
                            <div class="col-md-4 mb-3">
                                <label for="current_password" class="form-label">Current Password</label>
                                <input class="form-control" 
                                       type="password" 
                                       name="current_password" 
                                       id="current_password">
                            </div>

                            <!-- New Password -->
                            <div class="col-md-4 mb-3">
                                <label for="new_password" class="form-label">New Password</label>
                                <input class="form-control" 
                                       type="password" 
                                       name="new_password" 
                                       id="new_password">
                            </div>

                            <!-- Confirm New Password -->
                            <div class="col-md-4 mb-3">
                                <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                                <input class="form-control" 
                                       type="password" 
                                       name="new_password_confirmation" 
                                       id="new_password_confirmation">
                            </div>

                            <!-- Submit Button -->
                            <div class="col-12 mt-3">
                                <button class="btn btn-theme btn-black" type="submit">
                                    <i class="bi bi-check-circle me-2"></i>Update Account
                                </button>
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
/* Brand Colors */
:root {
    --artfauj-orange: #FF8C42;
    --artfauj-teal: #1B9AAA;
    --artfauj-orange-light: #FFB380;
    --artfauj-teal-light: #3DB5C4;
}

/* Stat Cards */
.stat-card {
    background: #fff;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    padding: 25px;
    text-align: center;
    transition: all 0.3s ease;
    height: 100%;
}

.stat-card:hover {
    border-color: var(--artfauj-orange);
    box-shadow: 0 4px 12px rgba(255, 140, 66, 0.25);
    transform: translateY(-3px);
}

.stat-card:nth-child(even):hover {
    border-color: var(--artfauj-teal);
    box-shadow: 0 4px 12px rgba(27, 154, 170, 0.25);
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--artfauj-teal) 0%, var(--artfauj-teal-light) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 15px;
    font-size: 28px;
    color: #fff;
}

.stat-content h3 {
    font-size: 28px;
    font-weight: 700;
    color: var(--artfauj-orange);
    margin-bottom: 5px;
}

.stat-card:nth-child(even) .stat-content h3 {
    color: var(--artfauj-teal);
}

.stat-content p {
    font-size: 14px;
    color: #6b7280;
    margin: 0;
}

/* Action Cards */
.action-card-link {
    text-decoration: none;
    color: inherit;
    display: block;
}

.action-card {
    background: #fff;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    padding: 25px;
    transition: all 0.3s ease;
    cursor: pointer;
    height: 100%;
}

.action-card:hover {
    border-color: var(--artfauj-orange);
    box-shadow: 0 8px 20px rgba(255, 140, 66, 0.25);
    transform: translateY(-5px);
}

.action-card:nth-child(2):hover {
    border-color: var(--artfauj-teal);
    box-shadow: 0 8px 20px rgba(27, 154, 170, 0.25);
}

.action-card-header {
    display: flex;
    align-items: center;
    gap: 15px;
}

.action-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    background: linear-gradient(135deg, var(--artfauj-teal) 0%, var(--artfauj-teal-light) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    color: #fff;
    flex-shrink: 0;
}

.action-icon-teal {
    background: linear-gradient(135deg, var(--artfauj-teal) 0%, var(--artfauj-teal-light) 100%);
}

.action-info {
    flex-grow: 1;
}

.action-info h4 {
    font-size: 18px;
    font-weight: 600;
    color: #1f2937;
    margin: 0 0 5px 0;
}

.action-info p {
    font-size: 14px;
    color: #6b7280;
    margin: 0;
}

.action-arrow {
    font-size: 20px;
    color: #9ca3af;
    transition: all 0.3s ease;
}

.action-card:hover .action-arrow {
    color: var(--artfauj-teal);
}

.action-card:nth-child(2):hover .action-arrow {
    color: var(--artfauj-teal);
}

/* Content Cards */
.section-content {
    margin-top: 30px;
    animation: slideDown 0.3s ease;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.content-card {
    background: #fff;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
}

.content-card h3 {
    font-size: 22px;
    font-weight: 600;
    color: var(--artfauj-orange);
}

/* Form Styling */
.form-label {
    font-weight: 600;
    color: #374151;
    margin-bottom: 8px;
    font-size: 14px;
}

.form-control {
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    padding: 12px 15px;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: var(--artfauj-teal);
    box-shadow: 0 0 0 3px rgba(27, 154, 170, 0.15);
    outline: none;
}

/* Button Styling */
.btn-theme {
    background: linear-gradient(135deg, var(--artfauj-teal) 0%, var(--artfauj-teal-light) 100%);
    border: none;
    color: #fff;
    padding: 10px 24px;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-theme:hover {
    background: linear-gradient(135deg, #158999 0%, var(--artfauj-teal) 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(27, 154, 170, 0.3);
}

/* Arrow Animation */
.action-arrow i {
    transition: transform 0.3s ease;
}

.action-arrow i.rotated {
    transform: rotate(180deg);
}

/* Table Badge Colors */
.badge.bg-info {
    background-color: var(--artfauj-teal) !important;
}

/* Responsive */
@media (max-width: 768px) {
    .stat-card, .action-card {
        margin-bottom: 15px;
    }
    
    .action-card-header {
        gap: 10px;
    }
    
    .action-icon {
        width: 50px;
        height: 50px;
        font-size: 24px;
    }
    
    .action-info h4 {
        font-size: 16px;
    }
}
</style>

<script>
function toggleSection(sectionId) {
    const section = document.getElementById(sectionId);
    const arrow = document.getElementById(sectionId.replace('-section', '-arrow'));
    
    // Close all other sections
    document.querySelectorAll('.section-content').forEach(content => {
        if (content.id !== sectionId && content.style.display === 'block') {
            content.style.display = 'none';
            const otherArrow = document.getElementById(content.id.replace('-section', '-arrow'));
            if (otherArrow) {
                otherArrow.classList.remove('rotated');
            }
        }
    });
    
    // Toggle current section
    if (section.style.display === 'none' || section.style.display === '') {
        section.style.display = 'block';
        arrow.classList.add('rotated');
        
        // Smooth scroll to section
        setTimeout(() => {
            section.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }, 100);
    } else {
        section.style.display = 'none';
        arrow.classList.remove('rotated');
    }
}

// Auto-open sections if there are errors or success messages
document.addEventListener('DOMContentLoaded', function() {
    @if($errors->any() || session('success') || session('error'))
        toggleSection('details-section');
    @endif
});
</script>
@endsection