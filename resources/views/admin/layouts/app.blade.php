<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Admin Panel')</title>

    <!--== Bootstrap CSS ==-->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <!--== Font-awesome Icons CSS ==-->
    <link href="{{ asset('assets/css/font-awesome.min.css') }}" rel="stylesheet" />
    
    <style>
        .admin-sidebar {
            min-height: 100vh;
            background: #2c3e50;
            color: white;
        }
        .admin-sidebar .nav-link {
            color: #ecf0f1;
            padding: 12px 20px;
            border-radius: 4px;
            margin: 5px 10px;
            transition: all 0.3s ease;
        }
        .admin-sidebar .nav-link:hover,
        .admin-sidebar .nav-link.active {
            background: #34495e;
            color: white;
        }
        .admin-sidebar .nav-link i {
            margin-right: 8px;
            width: 20px;
        }
        .admin-content {
            padding: 30px;
        }
        .admin-header {
            background: white;
            padding: 15px 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        .btn-action {
            margin: 0 3px;
        }
        .saree-img-thumb {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 4px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-label {
            font-weight: 600;
            margin-bottom: 8px;
        }
        .alert {
            margin-bottom: 20px;
        }
        .badge {
            padding: 5px 10px;
            border-radius: 4px;
        }
        .pending-badge {
            background: #f39c12;
            color: white;
            font-size: 11px;
            padding: 2px 8px;
            border-radius: 10px;
            margin-left: 5px;
        }
    </style>

    @stack('styles')
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-2 d-md-block admin-sidebar">
                <div class="p-3">
                    <h4 class="text-center mb-4">Admin Panel</h4>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('admin/dashboard') ? 'active' : '' }}" 
                               href="{{ route('admin.dashboard') }}">
                                <i class="fa fa-dashboard"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('admin/collections*') ? 'active' : '' }}" 
                               href="{{ route('admin.collections.index') }}">
                                <i class="fa fa-folder-open"></i> Collections
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('admin/sarees*') ? 'active' : '' }}" 
                               href="{{ route('admin.sarees.index') }}">
                                <i class="fa fa-shopping-bag"></i> Sarees
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('admin/blogs*') ? 'active' : '' }}" 
                               href="{{ route('admin.blogs.index') }}">
                                <i class="fa fa-file-text"></i> Blogs
                                @php
                                    $draftBlogs = \App\Models\Blog::where('is_published', false)->count();
                                @endphp
                                @if($draftBlogs > 0)
                                    <span class="pending-badge">{{ $draftBlogs }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('admin/videos*') ? 'active' : '' }}" 
                               href="{{ route('admin.videos.index') }}">
                                <i class="fa fa-video-camera"></i> Videos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('admin/reviews*') ? 'active' : '' }}" 
                               href="{{ route('admin.reviews.index') }}">
                                <i class="fa fa-star"></i> Reviews
                                @php
                                    $pendingCount = \App\Models\Review::where('is_approved', false)->count();
                                @endphp
                                @if($pendingCount > 0)
                                    <span class="pending-badge">{{ $pendingCount }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('admin/testimonials*') ? 'active' : '' }}" 
                               href="{{ route('admin.testimonials.index') }}">
                                <i class="fa fa-quote-left"></i> Testimonials
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('admin/contacts*') ? 'active' : '' }}" 
                               href="{{ route('admin.contacts.index') }}">
                                <i class="fa fa-envelope"></i> Contacts
                                @php
                                    $unreadCount = \App\Models\Contact::where('status', 'unread')->count();
                                @endphp
                                @if($unreadCount > 0)
                                    <span class="pending-badge">{{ $unreadCount }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('admin/newsletter-subscribers*') ? 'active' : '' }}" 
                               href="{{ route('admin.newsletter.index') }}">
                                <i class="fa fa-paper-plane"></i> Newsletter
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('admin/users*') ? 'active' : '' }}" 
                               href="{{ route('admin.users.index') }}">
                                <i class="fa fa-users"></i> Users
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('admin/orders*') ? 'active' : '' }}" 
                               href="{{ route('admin.orders.index') }}">
                                <i class="fa fa-shopping-cart"></i> Orders
                                @php
                                    $pendingOrders = \App\Models\Order::where('order_status', 'pending')->count();
                                @endphp
                                @if($pendingOrders > 0)
                                    <span class="pending-badge">{{ $pendingOrders }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('admin/contact-settings*') ? 'active' : '' }}" 
                               href="{{ route('admin.contact-settings.index') }}">
                                <i class="fa fa-cog"></i> Contact Settings
                            </a>
                        </li>
                        <li class="nav-item mt-4">
                            <a class="nav-link" href="{{ route('home') }}" target="_blank">
                                <i class="fa fa-external-link"></i> View Site
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-10 ms-sm-auto">
                <div class="admin-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3>@yield('page-title', 'Dashboard')</h3>
                        <div>
                            <span class="me-3">Welcome, {{ Auth::user()->name ?? 'Admin' }}</span>
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-danger">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="admin-content">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!--== Scripts ==-->
    <script src="{{ asset('assets/js/jquery-main.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>

    @stack('scripts')
</body>
</html>