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
                                <div class="header-action-account position-relative">
                                    <button class="btn-account user-account-btn" type="button">
                                        <i class="lastudioicon-single-01-2"></i>
                                        <span class="d-none d-lg-inline-block ms-1">{{ Auth::user()->name }}</span>
                                    </button>
                                    <ul class="account-dropdown-menu">
                                        @if(Auth::user()->isAdmin())
                                            <li>
                                                <a href="{{ route('admin.dashboard') }}">
                                                    <i class="fa fa-dashboard"></i> Admin Dashboard
                                                </a>
                                            </li>
                                            <li><hr style="margin: 5px 0; border-color: #e0e0e0;"></li>
                                        @endif
                                        <li>
                                            <a href="{{ route('home') }}">
                                                <i class="fa fa-user"></i> My Account
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('home') }}">
                                                <i class="fa fa-shopping-bag"></i> My Orders
                                            </a>
                                        </li>
                                        <li><hr style="margin: 5px 0; border-color: #e0e0e0;"></li>
                                        <li>
                                            <form action="{{ route('logout') }}" method="POST">
                                                @csrf
                                                <button type="submit" class="logout-button">
                                                    <i class="fa fa-sign-out"></i> Logout
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
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

<style>
/* Account Button - Remove border */
.user-account-btn {
    background: transparent !important;
    border: none !important;
    outline: none !important;
    box-shadow: none !important;
    padding: 0 !important;
    color: inherit;
    cursor: pointer;
}

.user-account-btn:hover,
.user-account-btn:focus,
.user-account-btn:active {
    background: transparent !important;
    border: none !important;
    outline: none !important;
    box-shadow: none !important;
}

/* Account Dropdown Styles */
.header-action-account.position-relative {
    position: relative;
}

.account-dropdown-menu {
    position: absolute;
    top: calc(100% + 15px);
    right: 0;
    background: #ffffff;
    min-width: 200px;
    box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
    border-radius: 4px;
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: all 0.3s ease;
    z-index: 9999;
    list-style: none;
    margin: 0;
    padding: 10px 0;
}

.header-action-account:hover .account-dropdown-menu {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.account-dropdown-menu::before {
    content: '';
    position: absolute;
    top: -8px;
    right: 20px;
    width: 0;
    height: 0;
    border-left: 8px solid transparent;
    border-right: 8px solid transparent;
    border-bottom: 8px solid #ffffff;
}

.account-dropdown-menu li {
    margin: 0;
    padding: 0;
}

.account-dropdown-menu li a,
.account-dropdown-menu li .logout-button {
    display: block;
    padding: 10px 20px;
    color: #333333;
    text-decoration: none;
    transition: all 0.3s ease;
    white-space: nowrap;
    font-size: 14px;
    border: none;
    background: none;
    width: 100%;
    text-align: left;
    cursor: pointer;
}

.account-dropdown-menu li .logout-button {
    color: #dc3545;
    font-weight: 500;
}

.account-dropdown-menu li a:hover,
.account-dropdown-menu li .logout-button:hover {
    background: #f8f9fa;
    padding-left: 25px;
}

.account-dropdown-menu li a i,
.account-dropdown-menu li .logout-button i {
    margin-right: 8px;
    width: 16px;
    display: inline-block;
}

/* Responsive */
@media (max-width: 991px) {
    .account-dropdown-menu {
        right: -10px;
    }
}
</style>
<!--== End Header Wrapper ==-->