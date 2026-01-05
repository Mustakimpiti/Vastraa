<!--== Start Header Wrapper ==-->
<header class="header-area header-default header-style2 header-transparent sticky-header">
    <div class="container-fluid">
        <div class="row row-gutter-0 align-items-center">
            <div class="col-12">
                <div class="header-align">
                    <div class="header-align-left">
                        <div class="header-logo-area">
                            <a href="{{ route('home') }}">
                                <img class="logo-main d-none d-sm-block" src="{{ asset('assets/img/logo-light.svg') }}" alt="Logo" />
                                <img class="logo-main d-sm-none" src="{{ asset('assets/img/logo-main-light.svg') }}" alt="Logo" />
                                <img class="logo-light" src="{{ asset('assets/img/logo-main.svg') }}" alt="Logo" />
                            </a>
                        </div>
                        <div class="header-navigation-area d-none d-xl-block">
                            <ul class="main-menu nav justify-content-center position-relative">
                                <li class="{{ Request::is('/') ? 'active' : '' }}">
                                    <a href="{{ route('home') }}">Home</a>
                                </li>
                                <li class="{{ Request::is('shop*') ? 'active' : '' }}">
                                    <a href="{{ route('shop') }}">Shop</a>
                                </li>
                                <li class="{{ Request::is('about') ? 'active' : '' }}">
                                    <a href="{{ route('about') }}">About Us</a>
                                </li>
                                <li class="{{ Request::is('shop-collections') ? 'active' : '' }}">
                                    <a href="{{ route('collections') }}">Collections</a>
                                </li>
                                <li class="{{ Request::is('contact') ? 'active' : '' }}">
                                    <a href="{{ route('contact') }}">Contact</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="header-align-right">
                        <div class="header-action-area">
                            @auth
                                <!-- If user is logged in -->
                                <div class="header-action-account">
                                    <div class="dropdown">
                                        <button class="btn-account dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="lastudioicon-single-01-2"></i>
                                            <span class="d-none d-lg-inline-block ms-1">{{ Auth::user()->name }}</span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                            @if(Auth::user()->isAdmin())
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                                        <i class="fa fa-dashboard"></i> Admin Dashboard
                                                    </a>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                            @endif
                                            <li>
                                                <a class="dropdown-item" href="{{ route('home') }}">
                                                    <i class="fa fa-user"></i> My Account
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{ route('home') }}">
                                                    <i class="fa fa-shopping-bag"></i> My Orders
                                                </a>
                                            </li>
                                          
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item text-danger">
                                                        <i class="fa fa-sign-out"></i> Logout
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            @else
                                <!-- If user is not logged in -->
                                <div class="header-action-login">
                                    <button class="btn-login" onclick="window.location.href='{{ route('login') }}'">
                                        <i class="lastudioicon-single-01-2"></i>
                                    </button>
                                </div>
                            @endauth

                            <div class="header-action-cart">
                                <button class="btn-cart cart-icon">
                                    <span class="cart-count">2</span>
                                    <i class="lastudioicon-shopping-cart-2"></i>
                                </button>
                            </div>

                            @guest
                                <div class="header-action-account d-none d-xxl-block">
                                    <button class="btn-sign-up" onclick="window.location.href='{{ route('login') }}'">
                                        Sign Up
                                    </button>
                                </div>
                            @endguest

                            <button class="btn-menu d-xl-none">
                                <i class="lastudioicon-menu-3-1"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!--== End Header Wrapper ==-->

{{-- @push('styles')
<style>
    .btn-account {
        background: none;
        border: none;
        color: inherit;
        cursor: pointer;
        padding: 8px 15px;
    }
    .btn-account:hover {
        opacity: 0.8;
    }
    .dropdown-menu {
        min-width: 200px;
        padding: 0.5rem 0;
        margin-top: 0.5rem;
    }
    .dropdown-item {
        padding: 0.5rem 1rem;
        font-size: 14px;
    }
    .dropdown-item i {
        margin-right: 8px;
        width: 16px;
    }
</style>
@endpush --}}