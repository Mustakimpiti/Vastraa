<!--== Start Footer Area Wrapper ==-->
<footer class="footer-area footer-style1">
    <div class="footer-main">
        <div class="container">
            <div class="row row-gutter-0">
                <div class="col-sm-6 col-md-3">
                    <div class="widget-item">
                        <div class="footer-logo-area mb-4">
                            <a href="{{ url('/') }}">
                                <img class="logo-main" src="{{ asset('assets/img/logo-main.svg') }}" alt="Logo" />
                            </a>
                        </div>
                        <p class="mb-0">Artfauj - Your one-stop destination for premium fashion and style.</p>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="widget-item mt-sm-0 mt-xs-20">
                        <h4 class="widget-title">Quick Links</h4>
                        <nav class="widget-menu-wrap">
                            <ul class="nav-menu nav">
                                <li><a href="{{ url('/') }}">HOME</a></li>
                                <li><a href="{{ url('/shop') }}">SHOP</a></li>
                                <li><a href="{{ url('/about') }}">ABOUT US</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="widget-item mt-md-0 mt-xs-20">
                        <h4 class="widget-title">Information</h4>
                        <nav class="widget-menu-wrap">
                            <ul class="nav-menu nav">
                                <li><a href="{{ url('/shop-collections') }}">COLLECTIONS</a></li>
                                <li><a href="{{ url('/contact') }}">CONTACT</a></li>
                                <li><a href="{{ url('/') }}">MY ACCOUNT</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="widget-item widget-social-item mt-md-0 mt-xs-20">
                        <h4 class="widget-title">Follow Us</h4>
                        <span class="mb-2 d-block">Stay connected on social media</span>
                        <div class="widget-social-icons">
                            <a href="#/"><i class="lastudioicon lastudioicon-b-facebook"></i></a>
                            <a href="#/"><i class="lastudioicon lastudioicon-b-pinterest"></i></a>
                            <a href="#/"><i class="lastudioicon lastudioicon-b-twitter"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="footer-bottom-content">
                        <p class="copyright text-center mb-0">© {{ date('Y') }} Artfauj. All Rights Reserved. Made with <i class="fa fa-heart text-danger"></i></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!--== End Footer Area Wrapper ==-->

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
                        <img src="{{ asset('assets/img/shop/quick-view1.jpg') }}" alt="Moren-Shop">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="single-product-info">
                        <h4 class="title">Product Simple</h4>
                        <div class="product-rating">
                            <div class="review">
                                <p><span></span>99 in stock</p>
                            </div>
                        </div>
                        <div class="prices">
                            <span class="price">£49.90</span>
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
                                <a class="btn-theme btn-black" href="{{ url('/shop-cart') }}">Add to cart</a>
                            </div>
                            <div class="action-bottom">
                                <a class="btn-wishlist" href="{{ url('/shop-wishlist') }}"><i class="labtn-icon labtn-icon-wishlist"></i>Add to wishlist</a>
                                <a class="btn-compare" href="{{ url('/shop-compare') }}"><i class="labtn-icon labtn-icon-compare"></i>Add to compare</a>
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
                                    <li><a href="{{ url('/shop') }}">Blazer,</a></li>
                                    <li><a href="{{ url('/shop') }}">Fashion,</a></li>
                                    <li><a href="{{ url('/shop') }}">wordpress,</a></li>
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
                            <a href="{{ url('/shop-single-product') }}">
                                <i class="lastudioicon-arrow-left"></i>
                            </a>
                            <a href="{{ url('/shop-single-product') }}">
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
            <form action="#" method="post">
                <div class="search-form position-relative">
                    <label for="search-input" class="sr-only">Search</label>
                    <input type="search" class="form-control" placeholder="Search" id="search-input">
                    <button class="search-button"><i class="lastudioicon-zoom-1"></i></button>
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
                            <a href="{{ url('/shop') }}"><img src="{{ asset('assets/img/shop/cart/1.jpg') }}" alt=""></a>
                        </div>
                        <div class="product-info">
                            <h4 class="title"><a href="{{ url('/shop') }}">I'm a Unicorn Earrings</a></h4>
                            <span class="info">1 × £69.00</span>
                        </div>
                        <div class="product-delete"><a href="#/">×</a></div>
                    </div>
                    <div class="product-cart-item">
                        <div class="product-img">
                            <a href="{{ url('/shop') }}"><img src="{{ asset('assets/img/shop/cart/2.jpg') }}" alt=""></a>
                        </div>
                        <div class="product-info">
                            <h4 class="title"><a href="{{ url('/shop') }}">Knit cropped cardigan</a></h4>
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
                    <a class="btn-theme" href="{{ url('/shop-cart') }}">View cart</a>
                    <a class="btn-theme" href="{{ url('/shop-checkout') }}">Checkout</a>
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