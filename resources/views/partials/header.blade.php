<!--== Start Header Wrapper ==-->
<header class="header-area header-default header-style2 header-transparent sticky-header">
    <div class="container-fluid">
        <div class="row row-gutter-0 align-items-center">
            <div class="col-12">
                <div class="header-align">
                    <div class="header-align-left">
                        <div class="header-logo-area">
                            <a href="{{ route('home') }}">
                                <img class="logo-main d-none d-sm-block" src="{{ asset('assets/img/logo.png') }}" alt="Logo" />
                                <img class="logo-main d-sm-none" src="{{ asset('assets/img/logo.png') }}" alt="Logo" />
                            </a>
                        </div>
                        <div class="header-navigation-area d-none d-xl-block">
                            <ul class="main-menu nav justify-content-center position-relative">
                                <li class="{{ Request::is('/') ? 'active' : '' }}">
                                    <a href="{{ route('home') }}">Home</a>
                                </li>
                                <li class="{{ Request::is('shop-collections') ? 'active' : '' }}">
                                    <a href="{{ route('shop') }}">Collection</a>
                                </li>
                                <li class="{{ Request::is('blogs*') ? 'active' : '' }}">
                                    <a href="{{ route('blogs') }}">Blog</a>
                                </li>
                                <li class="{{ Request::is('about') ? 'active' : '' }}">
                                    <a href="{{ route('about') }}">About</a>
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
                                                    <i class="icofont-dashboard"></i> Admin Dashboard
                                                </a>
                                            </li>
                                            <li><hr style="margin: 5px 0; border-color: #e0e0e0;"></li>
                                        @endif
                                        <li>
                                            <a href="{{ route('account') }}">
                                                <i class="icofont-user-alt-7"></i> My Account
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('orders.index') }}">
                                                <i class="icofont-shopping-cart"></i> My Orders
                                            </a>
                                        </li>
                                        <li><hr style="margin: 5px 0; border-color: #e0e0e0;"></li>
                                        <li>
                                            <form action="{{ route('logout') }}" method="POST">
                                                @csrf
                                                <button type="submit" class="logout-button">
                                                    <i class="icofont-logout"></i> Logout
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

                            <!-- Cart Icon with Dynamic Count - UPDATED -->
                            <div class="header-action-cart">
                                <a href="{{ route('cart.index') }}" class="btn-cart cart-icon direct-cart-link">
                                    @php
                                        $cartCount = \App\Models\Cart::where(function($query) {
                                            if (Auth::check()) {
                                                $query->where('user_id', Auth::id());
                                            } else {
                                                $query->where('session_id', session('cart_session_id', ''));
                                            }
                                        })->sum('quantity');
                                    @endphp
                                    <span class="cart-count" id="cart-count-badge">{{ $cartCount }}</span>
                                    <i class="lastudioicon-shopping-cart-2"></i>
                                </a>
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

/* Direct Cart Link - Prevent sidebar opening */
.direct-cart-link {
    pointer-events: auto !important;
}

/* Responsive */
@media (max-width: 991px) {
    .account-dropdown-menu {
        right: -10px;
    }
}
</style>

<script>
// Prevent cart sidebar from opening on cart icon click
document.addEventListener('DOMContentLoaded', function() {
    // Remove any click handlers that might open the cart sidebar
    const cartLinks = document.querySelectorAll('.direct-cart-link, .cart-icon');
    
    cartLinks.forEach(link => {
        // Stop event propagation to prevent sidebar opening
        link.addEventListener('click', function(e) {
            e.stopPropagation();
            e.stopImmediatePropagation();
        }, true);
    });
    
    // If there's a cart sidebar, prevent it from opening on cart icon click
    const cartSidebar = document.querySelector('.aside-cart-wrapper, .cart-offcanvas, .offcanvas-cart');
    if (cartSidebar) {
        // Ensure it stays closed
        cartSidebar.classList.remove('active', 'open', 'show');
    }
});

// Function to update cart count dynamically
function updateCartCount() {
    fetch('{{ route("cart.count") }}')
        .then(response => response.json())
        .then(data => {
            const badge = document.getElementById('cart-count-badge');
            if (badge) {
                badge.textContent = data.count;
                
                // Add animation effect
                badge.style.transform = 'scale(1.3)';
                setTimeout(() => {
                    badge.style.transform = 'scale(1)';
                }, 300);
            }
        })
        .catch(error => console.error('Error updating cart count:', error));
}

// Update cart count after page load if there are success messages
document.addEventListener('DOMContentLoaded', function() {
    @if(session('success') && (str_contains(session('success'), 'cart') || str_contains(session('success'), 'Cart')))
        updateCartCount();
    @endif
});
</script>
<!--== End Header Wrapper ==-->