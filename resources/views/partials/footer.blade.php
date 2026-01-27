<!--== Start Footer Area Wrapper ==-->
<footer class="footer-area footer-style2">
    <div class="footer-main">
        <div class="container">
            <div class="row row-gutter-0">
                <!-- Column 1: Logo and Description -->
                <div class="col-md-4 col-lg-4">
                    <div class="footer-logo-area">
                        <a href="{{ route('home') }}">
                            <img class="logo-main" src="{{ asset('assets/img/logo.png') }}" alt="Logo" />
                        </a>
                        <p>Where tradition meets elegance, draped in timeless beauty</p>                    
                    </div>
                </div>

                <!-- Column 2: Company & Useful Links -->
                <div class="col-md-4 col-lg-2">
                    <div class="widget-item mt-sm-40">
                        <h4>COMPANY</h4>
                        <nav class="widget-menu-wrap">
                            <ul class="nav-menu nav">
                                <li><a href="{{ route('about') }}">About Us</a></li>
                                <li><a href="{{ route('shop') }}">Our Studio</a></li>
                                <li><a href="{{ route('contact') }}">Contact Us</a></li>
                            </ul>
                        </nav>
                    </div>
                    <div class="widget-item widget-item-style2 mb-sm-30">
                        <h4>USEFUL</h4>
                        <nav class="widget-menu-wrap">
                            <ul class="nav-menu nav">
                                <li><a href="{{ route('contact') }}">Help Center</a></li>
                                <li><a href="#">Affiliate Program</a></li>
                                <li><a href="#">Services</a></li>
                                <li><a href="#">Terms & Conditions</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>

                <!-- Column 3: Categories & Hot Tags -->
                <div class="col-md-4 col-lg-3">
                    <div class="widget-item">
                        <h4>CATEGORIES</h4>
                        <nav class="widget-menu-wrap menu-col-2">
                            <ul class="nav-menu nav">
                                <li><a href="{{ route('shop') }}">All</a></li>
                                <li><a href="{{ route('shop') }}">Silk Sarees</a></li>
                                <li><a href="{{ route('shop') }}">Cotton Sarees</a></li>
                            </ul>
                            <ul class="nav-menu nav">
                                <li><a href="{{ route('shop') }}">Georgette</a></li>
                                <li><a href="{{ route('shop') }}">Chiffon</a></li>
                                <li><a href="{{ route('shop') }}">Designer</a></li>
                            </ul>
                        </nav>
                    </div>
                    <div class="widget-item widget-item-style2">
                        <h4>HOT TAGS</h4>
                        <nav class="widget-menu-wrap menu-col-2">
                            <ul class="nav-menu nav">
                                <li><a href="#">#Always Elegant</a></li>
                                <li><a href="#">#Garden Child</a></li>
                                <li><a href="#">#Girl Gang</a></li>
                                <li><a href="#">#A Love Story</a></li>
                            </ul>
                            <ul class="nav-menu nav">
                                <li><a href="#">#Dainty</a></li>
                                <li><a href="#">#Galactic Babe</a></li>
                                <li><a href="#">#Animal Lover</a></li>
                                <li><a href="#">#Creative Spirit</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>

                <!-- Column 4: Social Networks & Contact Info -->
                <div class="col-lg-3 d-block d-md-none d-lg-block">
                    <div class="widget-item mt-sm-40">
                        <h4>ON SOCIAL NETWORKS</h4>
                        @php
                            $contactSettings = \App\Models\ContactSetting::getSettings();
                        @endphp
                        <div class="widget-social-icons">
                            @if($contactSettings->facebook_url)
                                <a href="{{ $contactSettings->facebook_url }}" target="_blank" rel="noopener noreferrer">
                                    <i class="lastudioicon lastudioicon-b-facebook"></i>
                                </a>
                            @endif
                            
                            @if($contactSettings->pinterest_url)
                                <a href="{{ $contactSettings->pinterest_url }}" target="_blank" rel="noopener noreferrer">
                                    <i class="lastudioicon lastudioicon-b-pinterest"></i>
                                </a>
                            @endif
                            
                            @if($contactSettings->twitter_url)
                                <a href="{{ $contactSettings->twitter_url }}" target="_blank" rel="noopener noreferrer">
                                    <i class="lastudioicon lastudioicon-b-twitter"></i>
                                </a>
                            @endif
                            
                            @if($contactSettings->instagram_url)
                                <a href="{{ $contactSettings->instagram_url }}" target="_blank" rel="noopener noreferrer">
                                    <i class="lastudioicon lastudioicon-b-instagram"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="widget-item widget-item-style3">
                        <h4>CONTACT INFO</h4>
                        <ul class="widget-contact-info">
                            @if($contactSettings->phone1)
                                <li><a href="tel:{{ $contactSettings->phone1 }}">Phone: {{ $contactSettings->phone1 }}</a></li>
                            @endif
                            @if($contactSettings->email)
                                <li><a href="mailto:{{ $contactSettings->email }}">Email: {{ $contactSettings->email }}</a></li>
                            @endif
                            <li><a href="#">Open time: 9:00 - 19:00, Monday - Saturday</a></li>
                            <li class="info-address"><a href="#">Location: Vadodara</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!--== End Footer Area Wrapper ==-->

<!--== Scroll Top Button ==-->
<div class="scroll-to-top"><span class="icofont-arrow-up"></span></div>

<!--== Start Product Quick View ==-->
<aside class="product-quick-view-modal">
    <div class="product-quick-view-inner">
        <div class="product-quick-view-content">
            <button type="button" class="btn-close">
                <span class="close-icon"><i class="lastudioicon-e-remove"></i></span>
            </button>
            <div class="row row-gutter-0">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="thumb">
                        <img src="{{ asset('assets/img/shop/quick-view1.jpg') }}" alt="Artfauj">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="single-product-info">
                        <h4 class="title">Pure Natural Crepe Bemberg Saree (90 GSM)</h4>
                        <div class="product-rating">
                            <div class="review">
                                <p><span></span>99 in stock</p>
                            </div>
                        </div>
                        <div class="prices">
                            <span class="price">Rs 3999.00</span>
                        </div>
                        <p class="product-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fringilla quis ipsum enim viverra. Enim in morbi tincidunt ante luctus tincidunt integer. Sed adipiscing vehicula.</p>
                        <div class="quick-product-action">
                            <div class="action-top">
                                <div class="pro-qty-area">
                                    <div class="pro-qty">
                                        <input type="text" id="quantity" title="Quantity" value="1">
                                        <a href="#" class="inc qty-btn">+</a><a href="#" class="dec qty-btn">-</a>
                                    </div>
                                </div>
                                <a class="btn-theme btn-black" href="{{ route('cart.index') }}">Add to cart</a>
                            </div>
                            <div class="action-bottom">
                                <a class="btn-wishlist" href="#"><i class="labtn-icon labtn-icon-wishlist"></i>Add to wishlist</a>
                                <a class="btn-compare" href="#"><i class="labtn-icon labtn-icon-compare"></i>Add to compare</a>
                            </div>
                        </div>
                        <div class="product-ratting">
                            <div class="product-sku">
                                SKU: <span>REF. LA-276</span>
                            </div>
                        </div>
                        <div class="product-categorys">
                            <div class="product-category">
                                Category: <span>Uncategorized</span>
                            </div>
                        </div>
                        <div class="widget">
                            <h3 class="title">Tags:</h3>
                            <div class="widget-tags">
                                <ul>
                                    <li><a href="{{ route('shop') }}">Blazer,</a></li>
                                    <li><a href="{{ route('shop') }}">Fashion,</a></li>
                                    <li><a href="{{ route('shop') }}">wordpress,</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="product-social-info">
                            <a href="#"><span class="lastudioicon-b-facebook"></span></a>
                            <a href="#"><span class="lastudioicon-b-twitter"></span></a>
                            <a href="#"><span class="lastudioicon-b-linkedin"></span></a>
                            <a href="#"><span class="lastudioicon-b-pinterest"></span></a>
                        </div>
                        <div class="product-nextprev">
                            <a href="#">
                                <i class="lastudioicon-arrow-left"></i>
                            </a>
                            <a href="#">
                                <i class="lastudioicon-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="canvas-overlay"></div>
</aside>
<!--== End Product Quick View ==-->

<!--== Start Aside Search Menu ==-->
<div class="search-box-wrapper">
    <div class="search-box-content-inner">
        <div class="search-box-form-wrap">
            <div class="search-note">
                <p>Start typing and press Enter to search</p>
            </div>
            <form action="{{ route('shop') }}" method="GET">
                <div class="search-form position-relative">
                    <label for="search-input" class="sr-only">Search</label>
                    <input type="search" name="search" class="form-control" placeholder="Search" id="search-input">
                    <button class="search-button" type="submit"><i class="lastudioicon-zoom-1"></i></button>
                </div>
            </form>
        </div>
    </div>
    <a href="javascript:;" class="search-close"><i class="lastudioicon-e-remove"></i></a>
</div>
<!--== End Aside Search Menu ==-->

<!--== Start Sidebar Cart Menu ==-->
<aside class="sidebar-cart-modal">
    <div class="sidebar-cart-inner">
        <div class="sidebar-cart-content">
            <a class="cart-close" href="javascript:void(0);"><i class="lastudioicon-e-remove"></i></a>
            <div class="sidebar-cart">
                <h4 class="sidebar-cart-title">Shopping Cart</h4>
                <div class="product-cart">
                    <div class="product-cart-item">
                        <div class="product-img">
                            <a href="{{ route('shop') }}"><img src="{{ asset('assets/img/shop/cart/1.jpg') }}" alt=""></a>
                        </div>
                        <div class="product-info">
                            <h4 class="title"><a href="{{ route('shop') }}">I'm a Unicorn Earrings</a></h4>
                            <span class="info">1 × £69.00</span>
                        </div>
                        <div class="product-delete"><a href="#/">×</a></div>
                    </div>
                    <div class="product-cart-item">
                        <div class="product-img">
                            <a href="{{ route('shop') }}"><img src="{{ asset('assets/img/shop/cart/2.jpg') }}" alt=""></a>
                        </div>
                        <div class="product-info">
                            <h4 class="title"><a href="{{ route('shop') }}">Knit cropped cardigan</a></h4>
                            <span class="info">1 × £29.90</span>
                        </div>
                        <div class="product-delete"><a href="#/">×</a></div>
                    </div>
                </div>
                <div class="cart-total">
                    <h4>Subtotal: <span class="money">£98.90</span></h4>
                </div>
                <div class="shipping-info">
                    <div class="loading-bar">
                        <div class="load-percent"></div>
                        <div class="label-free-shipping">
                            <div class="free-shipping svg-icon-style">
                                <span class="svg-icon" id="svg-icon-shipping" data-svg-icon="{{ asset('assets/img/icons/shop1.svg') }}"></span>
                            </div>
                            <p>Spend £101.10 to get Free Shipping</p>
                        </div>
                    </div>
                </div>
                <div class="cart-checkout-btn">
                    <a class="btn-theme" href="{{ route('cart.index') }}">View cart</a>
                    <a class="btn-theme" href="{{ route('checkout') }}">Checkout</a>
                </div>
            </div>
        </div>
    </div>
</aside>
<div class="sidebar-cart-overlay"></div>
<!--== End Sidebar Cart Menu ==-->

<!--== Start Side Menu ==-->
<aside class="off-canvas-wrapper">
    <div class="off-canvas-inner">
        <div class="off-canvas-overlay d-none"></div>
        <div class="off-canvas-content">
            <div class="off-canvas-header">
                <div class="close-action">
                    <button class="btn-close"><i class="icofont-close-line"></i></button>
                </div>
            </div>
            <div class="off-canvas-item">
                <div class="res-mobile-menu">
                    <!-- Note Content Auto Generate By Jquery From Main Menu -->
                </div>
            </div>
            <div class="off-canvas-footer"></div>
        </div>
    </div>
</aside>
<!--== End Side Menu ==-->