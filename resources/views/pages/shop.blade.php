@extends('layouts.app')

@section('title', 'Shop - Clothing Shop')

@section('content')
<!--== Start Page Title Area ==-->
<section class="page-title-area bg-img" data-bg-img="{{ asset('assets/img/photos/bg-page1.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-title-content">
                    <h2 class="title">Shop</h2>
                    <div class="bread-crumbs">
                        <a href="{{ route('home') }}">Home<span class="breadcrumb-sep">></span></a>
                        <span class="active">Shop</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--== End Page Title Area ==-->

<!--== Start Product Area Wrapper ==-->
<section class="product-area product-shop-inner-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 order-1 order-lg-0">
                <div class="sidebar-area inner-right-padding shop-sidebar-area">
                    {{-- Search Widget --}}
                    <div class="widget">
                        <div class="widget-search-box">
                            <form action="{{ route('shop') }}" method="get">
                                <div class="form-input-item">
                                    <label for="search2" class="sr-only">Search Here</label>
                                    <input type="text" id="search2" name="search" placeholder="Search entire store…" value="{{ request('search') }}">
                                    <button type="submit" class="btn-src">
                                        <i class="icofont-search-1"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Categories Widget --}}
                    <div class="widget">
                        <h3 class="widget-title">Categories</h3>
                        <div class="widget-custom-menu">
                            <ul>
                                <li class="has-sub">
                                    <a class="collapsed" data-bs-toggle="collapse" href="#has-sub1" role="button" aria-expanded="false" aria-controls="has-sub1">Men</a>
                                    <ul class="collapse" id="has-sub1">
                                        <li><a href="{{ route('shop') }}">New in</a></li>
                                        <li><a href="{{ route('shop') }}">Clothing</a></li>
                                        <li><a href="{{ route('shop') }}">Coats</a></li>
                                        <li><a href="{{ route('shop') }}">Jackets</a></li>
                                        <li><a href="{{ route('shop') }}">Shirts</a></li>
                                        <li><a href="{{ route('shop') }}">T-shirts</a></li>
                                        <li><a href="{{ route('shop') }}">Blazers</a></li>
                                    </ul>
                                </li>
                                <li class="has-sub">
                                    <a class="collapsed active" data-bs-toggle="collapse" href="#has-sub2" role="button" aria-expanded="false" aria-controls="has-sub2">Women</a>
                                    <ul class="collapse" id="has-sub2">
                                        <li><a href="{{ route('shop') }}">New In</a></li>
                                        <li><a href="{{ route('shop') }}">Jeans</a></li>
                                        <li><a href="{{ route('shop') }}">Jackets</a></li>
                                        <li><a href="{{ route('shop') }}">Sweatshirts</a></li>
                                        <li><a href="{{ route('shop') }}">Skirts</a></li>
                                    </ul>
                                </li>
                                <li class="has-sub">
                                    <a class="collapsed" data-bs-toggle="collapse" href="#has-sub3" role="button" aria-expanded="false" aria-controls="has-sub3">Kids</a>
                                    <ul class="collapse" id="has-sub3">
                                        <li><a href="{{ route('shop') }}">Shoes</a></li>
                                        <li><a href="{{ route('shop') }}">Clothing</a></li>
                                        <li><a href="{{ route('shop') }}">Shirts</a></li>
                                        <li><a href="{{ route('shop') }}">Skirts</a></li>
                                    </ul>
                                </li>
                                <li class="has-sub">
                                    <a class="collapsed" data-bs-toggle="collapse" href="#has-sub4" role="button" aria-expanded="false" aria-controls="has-sub4">Accessories</a>
                                    <ul class="collapse" id="has-sub4">
                                        <li><a href="{{ route('shop') }}">Bags</a></li>
                                        <li><a href="{{ route('shop') }}">Shoes</a></li>
                                        <li><a href="{{ route('shop') }}">Wallets</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>

                    {{-- Price Filter Widget --}}
                    <div class="widget">
                        <h4 class="widget-title">By price</h4>
                        <div class="widget-price-filter">
                            <div class="slider-range" id="slider-range"></div>
                            <div class="slider-labels">
                                <span class="range-price-title">Price:</span>
                                <div class="caption">
                                    <span id="slider-range-value1"></span>
                                </div>
                                <span class="range-separator"> — </span>
                                <div class="caption">
                                    <span id="slider-range-value2"></span>
                                </div>
                            </div>
                            <a class="btn-filter" href="{{ route('shop') }}">Filter</a>
                        </div>
                    </div>

                    {{-- Color Filter Widget --}}
                    <div class="widget">
                        <h4 class="widget-title">By Color</h4>
                        <div class="widget-color-menu">
                            <ul>
                                <li class="blue"></li>
                                <li class="brown"></li>
                                <li class="red"></li>
                                <li class="violet"></li>
                            </ul>
                        </div>
                    </div>

                    {{-- Size Filter Widget --}}
                    <div class="widget">
                        <h4 class="widget-title">By Size</h4>
                        <div class="widget-size-menu">
                            <ul>
                                <li><a href="#">Blue</a>(9)</li>
                                <li><a href="#">Brown</a>(10)</li>
                                <li><a href="#">Red</a>(1)</li>
                                <li><a href="#">Violet</a>(10)</li>
                            </ul>
                        </div>
                    </div>

                    {{-- Brands Filter Widget --}}
                    <div class="widget">
                        <h4 class="widget-title">By brands</h4>
                        <div class="widget-size-menu">
                            <ul>
                                <li><a href="#">Blue</a>(9)</li>
                                <li><a href="#">Brown</a>(10)</li>
                                <li><a href="#">Red</a>(1)</li>
                                <li><a href="#">Violet</a>(10)</li>
                            </ul>
                        </div>
                    </div>

                    {{-- Banner Widget --}}
                    <div class="widget">
                        <div class="widget-banner">
                            <a href="#">
                                <img src="{{ asset('assets/img/photos/banner1.jpg') }}" alt="Image">
                            </a>
                        </div>
                    </div>

                    {{-- Instagram Widget --}}
                    <div class="widget">
                        <h3 class="widget-title">Instagram</h3>
                        <div class="widget-gallery">
                            <div class="row row-cols-3 row-gutter-4">
                                @for ($i = 1; $i <= 6; $i++)
                                <div class="col">
                                    <div class="gallery-item">
                                        <img src="{{ asset('assets/img/photos/gallery' . $i . '.jpg') }}" alt="Givest-HasTech">
                                        <a class="icon" href="#"><i class="icofont-instagram"></i></a>
                                    </div>
                                </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-9 order-0 order-lg-1">
                <div class="inner-left-padding">
                    {{-- Shop Toolbar --}}
                    <div class="shop-toolbar-wrap">
                        <div class="shop-toolbar-left">
                            <div class="product-showing-status">
                                <p class="count-result">Showing 1–12 of 88 results</p>
                            </div>
                        </div>
                        <div class="shop-toolbar-right">
                            <div class="product-sorting-menu product-view-count">
                                <span class="current">Show 12 <i class="lastudioicon-down-arrow"></i></span>
                                <ul>
                                    <li class="active"><a href="{{ route('shop') }}" class="active">Show 12</a></li>
                                    <li><a href="{{ route('shop') }}">Show 15</a></li>
                                    <li><a href="{{ route('shop') }}">Show 30</a></li>
                                </ul>
                            </div>
                            <div class="product-sorting-menu product-view-count">
                                <span class="current">Filters <i class="lastudioicon-down-arrow"></i></span>
                                <ul>
                                    <li class="active"><a href="{{ route('shop') }}" class="active">Filters</a></li>
                                    <li><a href="{{ route('shop') }}">Categories</a></li>
                                    <li><a href="{{ route('shop') }}">Tags</a></li>
                                </ul>
                            </div>
                            <div class="product-sorting-menu product-sorting">
                                <span class="current">Sort by Default <i class="lastudioicon-down-arrow"></i></span>
                                <ul>
                                    <li class="active"><a href="{{ route('shop') }}" class="active">Sort by Default</a></li>
                                    <li><a href="{{ route('shop') }}">Sort by Popularity</a></li>
                                    <li><a href="{{ route('shop') }}">Sort by Rated</a></li>
                                    <li><a href="{{ route('shop') }}">Sort by Latest</a></li>
                                    <li><a href="{{ route('shop') }}">Sort by Price: <i class="lastudioicon-arrow-up"></i></a></li>
                                    <li><a href="{{ route('shop') }}">Sort by Price: <i class="lastudioicon-arrow-down"></i></a></li>
                                </ul>
                            </div>
                            <div class="product-view-mode">
                                <nav>
                                    <div class="nav nav-tabs active" id="nav-tab" role="tablist">
                                        <button class="nav-link" id="nav-list-tab" data-bs-toggle="tab" data-bs-target="#nav-list" type="button" role="tab" aria-controls="nav-list" aria-selected="false">
                                            <i class="lastudioicon-list-bullet-2"></i>
                                        </button>
                                        <button class="nav-link" id="nav-grid-tab" data-bs-toggle="tab" data-bs-target="#nav-grid" type="button" role="tab" aria-controls="nav-grid" aria-selected="true">
                                            <i class="lastudioicon-microsoft"></i>
                                        </button>
                                    </div>
                                </nav>
                            </div>
                        </div>
                    </div>

                    {{-- Products Grid/List View --}}
                    <div class="tab-content" id="nav-tabContent">
                        {{-- Grid View --}}
                        <div class="tab-pane fade show active" id="nav-grid" role="tabpanel" aria-labelledby="nav-grid-tab">
                            <div class="row row-gutter-60 product-items-style4">
                                @php
                                $products = [
                                    ['img' => '13.jpg', 'title' => 'Believer Delicate Earrings', 'price' => '£69.00'],
                                    ['img' => '19.jpg', 'title' => 'Believer Delicate Earrings', 'price' => '£39.90'],
                                    ['img' => '20.jpg', 'title' => 'Black & Gold Forever Double Choker Necklace', 'price' => '£39.90'],
                                    ['img' => '31.jpg', 'title' => 'Black check texture shirt', 'price' => '£19.90'],
                                    ['img' => '4.jpg', 'title' => 'Black check texture shirt', 'price' => '£19.90'],
                                    ['img' => '33.jpg', 'title' => 'Blue wide-leg jeans', 'price' => '£35.90'],
                                    ['img' => '6.jpg', 'title' => 'Blue wide-leg jeans', 'price' => '£35.90'],
                                    ['img' => '26.jpg', 'title' => 'buttoned waistcoat', 'price' => '£45.90'],
                                    ['img' => '8.jpg', 'title' => 'Buttoned Waistcoat', 'price' => '£45.90'],
                                    ['img' => '11.jpg', 'title' => 'Disappearing Into the Sea Necklace', 'price' => '£39.90'],
                                    ['img' => '21.jpg', 'title' => 'Disappearing Into the Sea Necklace', 'price' => '£49.90'],
                                    ['img' => '87.jpg', 'title' => 'Double Breasted Blazer', 'price' => '£49.90'],
                                ];
                                @endphp

                                @foreach($products as $product)
                                <div class="col-sm-6 col-md-4">
                                    <!-- Start Product Item -->
                                    <div class="product-item">
                                        <div class="product-thumb">
                                            <a href="#">
                                                <img src="{{ asset('assets/img/shop/' . $product['img']) }}" alt="Moren-Shop">
                                                <span class="thumb-overlay"></span>
                                            </a>
                                            <div class="product-action action-style3">
                                                <a class="action-cart ht-tooltip" data-tippy-content="Add to cart" href="{{ route('cart') }}" title="Add to cart">
                                                    <i class="lastudioicon-shopping-cart-3"></i>
                                                </a>
                                                <a class="action-quick-view ht-tooltip" data-tippy-content="Quick View" href="javascript:void(0);" title="Quick View">
                                                    <i class="lastudioicon-search-zoom-in"></i>
                                                </a>
                                        
                                                <a class="action-compare ht-tooltip" data-tippy-content="Add to compare" href="#" title="Add to compare">
                                                    <i class="lastudioicon-compare"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="product-info info-style2">
                                            <div class="content-inner">
                                                <h4 class="title"><a href="#">{{ $product['title'] }}</a></h4>
                                                <div class="prices">
                                                    <span class="price">{{ $product['price'] }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Product Item -->
                                </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- List View --}}
                        <div class="tab-pane fade" id="nav-list" role="tabpanel" aria-labelledby="nav-list-tab">
                            <div class="row">
                                <div class="col-12 product-items-list">
                                    @php
                                    $listProducts = [
                                        ['img' => 'list1.jpg', 'title' => 'Believer Delicate Earrings', 'price' => '£69.00'],
                                        ['img' => 'list2.jpg', 'title' => 'Believer Delicate Earrings', 'price' => '£39.00'],
                                        ['img' => 'list3.jpg', 'title' => 'Black & Gold Forever Double Choker Necklace', 'price' => '£39.00'],
                                        ['img' => 'list4.jpg', 'title' => 'Black check texture shirt', 'price' => '£19.90'],
                                        ['img' => 'list5.jpg', 'title' => 'Black check texture shirt', 'price' => '£19.90'],
                                    ];
                                    @endphp

                                    @foreach($listProducts as $product)
                                    <!-- Start Product Item -->
                                    <div class="product-item">
                                        <div class="product-thumb">
                                            <a href="#">
                                                <img src="{{ asset('assets/img/shop/' . $product['img']) }}" alt="Moren-Shop">
                                                <span class="thumb-overlay"></span>
                                            </a>
                                            <div class="product-action">
                                                <a class="action-quick-view ht-tooltip" data-tippy-content="Quick View" href="javascript:void(0);" title="Quick View">
                                                    <i class="lastudioicon-search-zoom-in"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="product-info">
                                            <div class="content-inner">
                                                <h4 class="title"><a href="#">{{ $product['title'] }}</a></h4>
                                                <div class="prices">
                                                    <span class="price">{{ $product['price'] }}</span>
                                                </div>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fringilla quis ipsum enim viverra. Enim in morbi tincidunt ante luctus tincidunt integer. Sed adipiscing vehicula.</p>
                                                <div class="product-action-btn">
                                                    <a class="btn-add-cart btn-theme" href="{{ route('cart') }}">Add to cart</a>
                                                   
                                                    <a class="btn-compare" href="#">
                                                        <i class="lastudioicon-compare"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Product Item -->
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Pagination --}}
                    <div class="pagination-area">
                        <nav>
                            <ul class="page-numbers">
                                <li>
                                    <a class="page-number active" href="{{ route('shop') }}">1</a>
                                </li>
                                <li>
                                    <a class="page-number" href="{{ route('shop') }}">2</a>
                                </li>
                                <li>
                                    <a class="page-number" href="{{ route('shop') }}">3</a>
                                </li>
                                <li>
                                    <a class="page-number" href="{{ route('shop') }}">4</a>
                                </li>
                                <li>
                                    <a class="page-numbe" href="{{ route('shop') }}">…</a>
                                </li>
                                <li>
                                    <a class="page-number" href="{{ route('shop') }}">6</a>
                                </li>
                                <li>
                                    <a class="page-number" href="{{ route('shop') }}">7</a>
                                </li>
                                <li>
                                    <a class="page-number" href="{{ route('shop') }}">8</a>
                                </li>
                                <li>
                                    <a class="page-number next" href="{{ route('shop') }}">
                                        <i class="icofont-long-arrow-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--== End Product Area Wrapper ==-->
@endsection