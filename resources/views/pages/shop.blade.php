@extends('layouts.app')

@section('title', 'Shop Sarees - Clothing Shop')

@section('content')
<section class="page-title-area bg-img" data-bg-img="{{ asset('assets/img/photos/bg-page1.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-title-content">
                    <h2 class="title">Shop</h2>
                    <div class="bread-crumbs">
                        <a href="{{ route('home') }}">Home<span class="breadcrumb-sep">></span></a>
                        <span class="active">Collection</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="product-area product-shop-inner-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="shop-toolbar-wrap">
                    <div class="shop-toolbar-left">
                        <div class="product-showing-status">
                            @php
                                $firstItem = $sarees->firstItem() ?? 0;
                                $lastItem = $sarees->lastItem() ?? 0;
                                $total = $sarees->total();
                            @endphp
                            <p class="count-result">Showing {{ $firstItem }}–{{ $lastItem }} of {{ $total }} results</p>
                        </div>
                    </div>
                    <div class="shop-toolbar-right">
                        <div class="product-sorting-menu product-view-count">
                            @php
                                $perPage = request('per_page', 12);
                            @endphp
                            <span class="current">Show {{ $perPage }} <i class="lastudioicon-down-arrow"></i></span>
                            <ul>
                                <li class="{{ $perPage == 12 ? 'active' : '' }}">
                                    <a href="{{ route('shop', array_merge(request()->except('page'), ['per_page' => 12])) }}">Show 12</a>
                                </li>
                                <li class="{{ $perPage == 15 ? 'active' : '' }}">
                                    <a href="{{ route('shop', array_merge(request()->except('page'), ['per_page' => 15])) }}">Show 15</a>
                                </li>
                                <li class="{{ $perPage == 30 ? 'active' : '' }}">
                                    <a href="{{ route('shop', array_merge(request()->except('page'), ['per_page' => 30])) }}">Show 30</a>
                                </li>
                            </ul>
                        </div>
                        <div class="product-sorting-menu product-sorting">
                            @php
                                $sortType = request('sort', 'default');
                                $sortLabel = 'Sort by Default';
                                switch($sortType) {
                                    case 'popularity': $sortLabel = 'Sort by Popularity'; break;
                                    case 'rating': $sortLabel = 'Sort by Rated'; break;
                                    case 'latest': $sortLabel = 'Sort by Latest'; break;
                                    case 'price_low': $sortLabel = 'Sort by Price: Low to High'; break;
                                    case 'price_high': $sortLabel = 'Sort by Price: High to Low'; break;
                                }
                            @endphp
                            <span class="current">{{ $sortLabel }} <i class="lastudioicon-down-arrow"></i></span>
                            <ul>
                                <li class="{{ $sortType == 'default' ? 'active' : '' }}">
                                    <a href="{{ route('shop', array_merge(request()->except('page'), ['sort' => 'default'])) }}">Sort by Default</a>
                                </li>
                                <li class="{{ $sortType == 'popularity' ? 'active' : '' }}">
                                    <a href="{{ route('shop', array_merge(request()->except('page'), ['sort' => 'popularity'])) }}">Sort by Popularity</a>
                                </li>
                                <li class="{{ $sortType == 'rating' ? 'active' : '' }}">
                                    <a href="{{ route('shop', array_merge(request()->except('page'), ['sort' => 'rating'])) }}">Sort by Rated</a>
                                </li>
                                <li class="{{ $sortType == 'latest' ? 'active' : '' }}">
                                    <a href="{{ route('shop', array_merge(request()->except('page'), ['sort' => 'latest'])) }}">Sort by Latest</a>
                                </li>
                                <li class="{{ $sortType == 'price_low' ? 'active' : '' }}">
                                    <a href="{{ route('shop', array_merge(request()->except('page'), ['sort' => 'price_low'])) }}">Sort by Price: Low to High</a>
                                </li>
                                <li class="{{ $sortType == 'price_high' ? 'active' : '' }}">
                                    <a href="{{ route('shop', array_merge(request()->except('page'), ['sort' => 'price_high'])) }}">Sort by Price: High to Low</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="row row-gutter-60 product-items-style4">
                    @forelse($sarees as $saree)
                    <div class="col-sm-6 col-md-4">
                        <!-- Start Product Item -->
                        <div class="product-item">
                            <div class="product-thumb">
                                <a href="{{ route('product.show', $saree->slug) }}">
                                    @php
                                        $imageUrl = $saree->featured_image 
                                            ? asset($saree->featured_image) 
                                            : asset('assets/img/shop/default.jpg');
                                    @endphp
                                    <img src="{{ $imageUrl }}" alt="{{ $saree->name }}">
                                    <span class="thumb-overlay"></span>
                                </a>
                                <div class="product-action action-style3">
                                    <a class="action-cart ht-tooltip" data-tippy-content="Add to cart" href="{{ route('product.show', $saree->slug) }}" title="Add to cart">
                                        <i class="lastudioicon-shopping-cart-3"></i>
                                    </a>
                                    <a class="action-quick-view ht-tooltip" data-tippy-content="Quick View" href="javascript:void(0);" title="Quick View" 
                                       onclick="showQuickView({{ $saree->id }}, '{{ $saree->name }}', '{{ $imageUrl }}', '{{ $saree->hasDiscount() ? number_format($saree->sale_price, 2) : number_format($saree->price, 2) }}', '{{ $saree->hasDiscount() ? number_format($saree->price, 2) : '' }}', '{{ $saree->stock_quantity }}', '{{ addslashes($saree->short_description ?? $saree->description) }}', '{{ $saree->sku ?? 'N/A' }}', '{{ route('product.show', $saree->slug) }}', '{{ $saree->hasDiscount() ? $saree->getDiscountPercentage() : '' }}')">
                                        <i class="lastudioicon-search-zoom-in"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="product-info info-style2">
                                <div class="content-inner">                  
                                    <h4 class="title"><a href="{{ route('product.show', $saree->slug) }}">{{ $saree->name }}</a></h4>
                                    <div class="prices">
                                        @if($saree->hasDiscount())
                                            <span class="price-old">₹{{ number_format($saree->price, 2) }}</span>
                                            <span class="price">₹{{ number_format($saree->sale_price, 2) }}</span>
                                        @else
                                            <span class="price">₹{{ number_format($saree->price, 2) }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Product Item -->
                    </div>
                    @empty
                    <div class="col-md-12 text-center py-5">
                        <h3>No sarees found</h3>
                        <p>Try adjusting your search criteria</p>
                        <a href="{{ route('shop') }}" class="btn-theme btn-black btn-border mt-3">Clear Search</a>
                    </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($sarees->hasPages())
                <div class="pagination-area">
                    <nav>
                        <ul class="page-numbers">
                            @if ($sarees->onFirstPage())
                                <li><span class="page-number disabled">«</span></li>
                            @else
                                @php
                                    $prevUrl = $sarees->appends(request()->except('page'))->previousPageUrl();
                                @endphp
                                <li><a class="page-number" href="{{ $prevUrl }}">«</a></li>
                            @endif

                            @php
                                $urlRange = $sarees->getUrlRange(1, $sarees->lastPage());
                            @endphp
                            @foreach ($urlRange as $page => $url)
                                @if ($page == $sarees->currentPage())
                                    <li><a class="page-number active" href="#">{{ $page }}</a></li>
                                @else
                                    @php
                                        $pageUrl = $sarees->appends(request()->except('page'))->url($page);
                                    @endphp
                                    <li><a class="page-number" href="{{ $pageUrl }}">{{ $page }}</a></li>
                                @endif
                            @endforeach

                            @if ($sarees->hasMorePages())
                                @php
                                    $nextUrl = $sarees->appends(request()->except('page'))->nextPageUrl();
                                @endphp
                                <li><a class="page-number next" href="{{ $nextUrl }}"><i class="icofont-long-arrow-right"></i></a></li>
                            @else
                                <li><span class="page-number disabled">»</span></li>
                            @endif
                        </ul>
                    </nav>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
function showQuickView(id, name, image, price, oldPrice, stock, description, sku, productUrl, discount) {
    // Update product image
    document.querySelector('.product-quick-view-modal .thumb img').src = image;
    
    // Update product title
    document.querySelector('.product-quick-view-modal .title').textContent = name;
    
    // Update stock info
    document.querySelector('.product-quick-view-modal .review p').innerHTML = '<span></span>' + stock + ' in stock';
    
    // Update prices with discount badge
    const pricesDiv = document.querySelector('.product-quick-view-modal .prices');
    if (oldPrice && discount) {
        pricesDiv.innerHTML = '<span class="price-old">₹' + oldPrice + '</span><span class="price">₹' + price + '</span><span class="badge badge-sale">-' + discount + '%</span>';
    } else {
        pricesDiv.innerHTML = '<span class="price">₹' + price + '</span>';
    }
    
    // Update description
    document.querySelector('.product-quick-view-modal .product-desc').textContent = description.substring(0, 200) + '...';
    
    // Update SKU
    document.querySelector('.product-quick-view-modal .product-sku span').textContent = sku;
    
    // Hide wishlist and compare buttons
    const actionBottom = document.querySelector('.product-quick-view-modal .action-bottom');
    if (actionBottom) {
        actionBottom.style.display = 'none';
    }
    
    // Update all links to product page
    const links = document.querySelectorAll('.product-quick-view-modal a[href*="shop-single-product"], .product-quick-view-modal a.btn-theme');
    links.forEach(link => {
        if (!link.classList.contains('btn-close')) {
            link.href = productUrl;
        }
    });
    
    // Show modal
    document.querySelector('.product-quick-view-modal').classList.add('open');
    document.querySelector('.canvas-overlay').classList.add('open');
}
</script>

<style>
/* Quick View Price Styles */
.product-quick-view-modal .prices {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 20px;
}

.product-quick-view-modal .price-old {
    text-decoration: line-through;
    color: #999;
    font-size: 18px;
    font-weight: 400;
}

.product-quick-view-modal .price {
    color: #000;
    font-size: 28px;
    font-weight: 600;
}

.product-quick-view-modal .badge-sale {
    background: linear-gradient(135deg, #d4af37 0%, #f9d77e 50%, #d4af37 100%);
    color: #ffffff !important;
    padding: 4px 10px;
    border-radius: 4px;
    font-size: 14px;
    font-weight: 700;
    display: inline-block;
    box-shadow: 0 2px 8px rgba(212, 175, 55, 0.3);
    text-shadow: 0 1px 3px rgba(0, 0, 0, 0.5);
}

/* Hide wishlist and compare in quick view */
.product-quick-view-modal .action-bottom {
    display: none !important;
}
</style>
@endpush
@endsection