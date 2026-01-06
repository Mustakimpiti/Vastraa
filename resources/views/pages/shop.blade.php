@extends('layouts.app')

@section('title', 'Shop Sarees - Clothing Shop')

@push('styles')
<style>
/* Product Image Uniform Sizing - Shop Page */
.product-items-style4 .product-thumb {
    position: relative;
    overflow: hidden;
    padding-bottom: 125%; /* 4:5 aspect ratio like related products */
    background: #f8f9fa;
}

.product-items-style4 .product-thumb > a {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: block;
}

.product-items-style4 .product-thumb img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    transition: transform 0.3s ease;
}

.product-items-style4 .product-item:hover .product-thumb img {
    transform: scale(1.05);
}

.product-items-style4 .product-thumb .thumb-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

/* Attractive Badge Styling - No Overlap */
.product-items-style4 .product-thumb .badge {
    position: absolute;
    top: 15px;
    left: 15px;
    background: linear-gradient(135deg, #ff4757 0%, #ff6b81 100%);
    color: #fff;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 700;
    z-index: 2;
    box-shadow: 0 4px 15px rgba(255, 71, 87, 0.4);
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.05);
    }
}

.product-items-style4 .product-thumb .product-action {
    position: absolute;
    z-index: 3;
}

/* Reduce spacing between widgets */
.shop-sidebar-area .widget {
    margin-bottom: 30px !important;
}

.widget-title {
    margin-bottom: 15px !important;
}

/* Price Filter Slider Styling - Template Style */
.irs--flat .irs-line {
    background-color: #e0e0e0 !important;
    height: 4px !important;
}

.irs--flat .irs-bar {
    background-color: #00bcd4 !important;
    height: 4px !important;
}

.irs--flat .irs-handle {
    width: 16px !important;
    height: 16px !important;
    top: 50% !important;
    transform: translateY(-50%) !important;
}

.irs--flat .irs-handle > i:first-child {
    background-color: #00bcd4 !important;
    width: 16px !important;
    height: 16px !important;
    border-radius: 50% !important;
    border: 3px solid #fff !important;
    box-shadow: 0 2px 4px rgba(0,0,0,0.2) !important;
}

.irs--flat .irs-handle.state_hover > i:first-child,
.irs--flat .irs-handle:hover > i:first-child {
    background-color: #00acc1 !important;
}

.irs--flat .irs-from, 
.irs--flat .irs-to, 
.irs--flat .irs-single {
    display: none !important;
}

.irs--flat .irs-min,
.irs--flat .irs-max {
    display: none !important;
}

/* Price range labels */
.slider-labels {
    display: flex;
    align-items: center;
    margin-top: 15px;
    margin-bottom: 15px;
    font-size: 14px;
}

.range-price-title {
    font-weight: 500;
    margin-right: 8px;
}

.slider-labels .caption {
    display: inline-block;
}

.slider-labels .caption span {
    color: #333;
    font-weight: 500;
}

.range-separator {
    margin: 0 8px;
    color: #999;
}

/* Filter button */
.btn-filter {
    display: inline-block;
    background-color: #000 !important;
    color: #fff !important;
    border: 1px solid #000 !important;
    padding: 10px 30px;
    text-transform: uppercase;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 1px;
    transition: all 0.3s ease;
    cursor: pointer;
    text-decoration: none;
}

.btn-filter:hover {
    background-color: #fff !important;
    color: #000 !important;
}

/* Hide the number inputs - use only slider */
.price-inputs {
    display: none;
}

/* Checkbox Filter Styling */
.filter-checkbox-label {
    display: flex;
    align-items: center;
    cursor: pointer;
    padding: 6px 0;
    transition: all 0.3s ease;
}

.filter-checkbox-label:hover {
    color: #000;
}

.filter-checkbox {
    width: 18px;
    height: 18px;
    margin-right: 10px;
    cursor: pointer;
    accent-color: #00bcd4;
}

.filter-checkbox-label span {
    user-select: none;
}

.widget-size-menu ul li {
    list-style: none;
    margin: 0;
    padding: 0;
}

.widget-size-menu ul {
    padding: 0;
    margin: 0;
}

.widget-size-menu,
.widget-custom-menu {
    margin-top: 15px;
}
</style>
@endpush

@section('content')
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

<section class="product-area product-shop-inner-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 order-1 order-lg-0">
                <div class="sidebar-area inner-right-padding shop-sidebar-area">
                    
                    <div class="widget">
                        <div class="widget-search-box">
                            <form action="{{ route('shop') }}" method="get">
                                @foreach(request()->except(['search', 'page']) as $key => $value)
                                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                @endforeach
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

                    <div class="widget">
                        <h3 class="widget-title">Collections</h3>
                        <div class="widget-custom-menu">
                            <ul>
                                <li class="{{ !request('collection') ? 'active' : '' }}">
                                    <a href="{{ route('shop', array_merge(request()->except(['collection', 'page']))) }}">All Collections</a>
                                </li>
                                @foreach($collections as $collection)
                                <li class="{{ request('collection') == $collection->id ? 'active' : '' }}">
                                    <a href="{{ route('shop', array_merge(request()->except('page'), ['collection' => $collection->id])) }}">
                                        {{ $collection->name }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="widget">
                        <h4 class="widget-title">By price</h4>
                        <div class="widget-price-filter">
                            <form id="price-filter-form" action="{{ route('shop') }}" method="get">
                                @foreach(request()->except(['min_price', 'max_price', 'page']) as $key => $value)
                                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                @endforeach
                                
                                @php
                                    $minVal = request('min_price', $priceRange['min']);
                                    $maxVal = request('max_price', $priceRange['max']);
                                @endphp
                                
                                <div class="price-inputs mb-3">
                                    <div class="d-flex gap-2">
                                        <input type="number" name="min_price" id="min_price" class="form-control" placeholder="Min" value="{{ $minVal }}" min="{{ $priceRange['min'] }}" max="{{ $priceRange['max'] }}">
                                        <input type="number" name="max_price" id="max_price" class="form-control" placeholder="Max" value="{{ $maxVal }}" min="{{ $priceRange['min'] }}" max="{{ $priceRange['max'] }}">
                                    </div>
                                </div>
                                
                                <div class="slider-range" id="slider-range"></div>
                                <div class="slider-labels">
                                    <span class="range-price-title">Price:</span>
                                    <div class="caption">
                                        <span id="slider-range-value1">₹{{ number_format($minVal) }}</span>
                                    </div>
                                    <span class="range-separator"> — </span>
                                    <div class="caption">
                                        <span id="slider-range-value2">₹{{ number_format($maxVal) }}</span>
                                    </div>
                                </div>
                                <button type="submit" class="btn-filter">Filter</button>
                            </form>
                        </div>
                    </div>

                    @if($fabrics->count() > 0)
                    <div class="widget">
                        <h4 class="widget-title">By Fabric</h4>
                        <div class="widget-size-menu">
                            <ul>
                                @foreach($fabrics as $fabric)
                                <li class="{{ request('fabric') == $fabric ? 'active' : '' }}">
                                    <label class="filter-checkbox-label">
                                        <input type="checkbox" class="filter-checkbox" 
                                               {{ request('fabric') == $fabric ? 'checked' : '' }}
                                               onchange="window.location.href='{{ request('fabric') == $fabric ? route('shop', array_merge(request()->except(['fabric', 'page']))) : route('shop', array_merge(request()->except('page'), ['fabric' => $fabric])) }}'">
                                        <span>{{ $fabric }}</span>
                                    </label>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif

                    @if($occasions->count() > 0)
                    <div class="widget">
                        <h4 class="widget-title">By Occasion</h4>
                        <div class="widget-size-menu">
                            <ul>
                                @foreach($occasions as $occasion)
                                <li class="{{ request('occasion') == $occasion ? 'active' : '' }}">
                                    <label class="filter-checkbox-label">
                                        <input type="checkbox" class="filter-checkbox" 
                                               {{ request('occasion') == $occasion ? 'checked' : '' }}
                                               onchange="window.location.href='{{ request('occasion') == $occasion ? route('shop', array_merge(request()->except(['occasion', 'page']))) : route('shop', array_merge(request()->except('page'), ['occasion' => $occasion])) }}'">
                                        <span>{{ $occasion }}</span>
                                    </label>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif

                    @if($workTypes->count() > 0)
                    <div class="widget">
                        <h4 class="widget-title">By Work Type</h4>
                        <div class="widget-size-menu">
                            <ul>
                                @foreach($workTypes as $workType)
                                <li class="{{ request('work_type') == $workType ? 'active' : '' }}">
                                    <label class="filter-checkbox-label">
                                        <input type="checkbox" class="filter-checkbox" 
                                               {{ request('work_type') == $workType ? 'checked' : '' }}
                                               onchange="window.location.href='{{ request('work_type') == $workType ? route('shop', array_merge(request()->except(['work_type', 'page']))) : route('shop', array_merge(request()->except('page'), ['work_type' => $workType])) }}'">
                                        <span>{{ $workType }}</span>
                                    </label>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif

                    @if(count(request()->except('page')) > 0)   
                    <div class="widget">
                        <a href="{{ route('shop') }}" class="btn-theme btn-black btn-border w-100">Clear All Filters</a>
                    </div>
                    @endif
                </div>
            </div>

            <div class="col-lg-9 order-0 order-lg-1">
                <div class="inner-left-padding">
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
    <div class="product-item">
        <div class="product-thumb">
            <a href="{{ route('product.show', $saree->slug) }}">
                @php
                    // Changed from asset('storage/') to asset() directly
                    $imageUrl = $saree->featured_image 
                        ? asset($saree->featured_image) 
                        : asset('assets/img/shop/default.jpg');
                @endphp
                <img src="{{ $imageUrl }}" alt="{{ $saree->name }}">
                <span class="thumb-overlay"></span>
            </a>
                                    @if($saree->hasDiscount())
                                    @php
                                        $discount = $saree->getDiscountPercentage();
                                    @endphp
                                    <span class="badge">-{{ $discount }}%</span>
                                    @endif
                                    <div class="product-action action-style3">
                                        <a class="action-cart ht-tooltip" data-tippy-content="Add to cart" href="{{ route('product.show', $saree->slug) }}" title="Add to cart">
                                            <i class="lastudioicon-shopping-cart-3"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="product-info info-style2">
                                    <div class="content-inner">                  
                                        <h4 class="title"><a href="{{ route('product.show', $saree->slug) }}">{{ $saree->name }}</a></h4>
                                        <div class="prices">
                                            @if($saree->hasDiscount())
                                                @php
                                                    $regularPrice = number_format($saree->price, 2);
                                                    $salePrice = number_format($saree->sale_price, 2);
                                                @endphp
                                                <span class="price-old">₹{{ $regularPrice }}</span>
                                                <span class="price">₹{{ $salePrice }}</span>
                                            @else
                                                @php
                                                    $price = number_format($saree->price, 2);
                                                @endphp
                                                <span class="price">₹{{ $price }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-md-12 text-center py-5">
                            <h3>No sarees found</h3>
                            <p>Try adjusting your filters or search criteria</p>
                            <a href="{{ route('shop') }}" class="btn-theme btn-black btn-border mt-3">Clear Filters</a>
                        </div>
                        @endforelse
                    </div>

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
    </div>
</section>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/js/ion.rangeSlider.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/css/ion.rangeSlider.min.css">

<script>
document.addEventListener('DOMContentLoaded', function() {
    var minPrice = {{ $priceRange['min'] }};
    var maxPrice = {{ $priceRange['max'] }};
    var currentMin = {{ request('min_price', $priceRange['min']) }};
    var currentMax = {{ request('max_price', $priceRange['max']) }};
    
    var slider = document.getElementById('slider-range');
    if (slider && typeof $.fn.ionRangeSlider !== 'undefined') {
        $(slider).ionRangeSlider({
            type: 'double',
            min: minPrice,
            max: maxPrice,
            from: currentMin,
            to: currentMax,
            prefix: '₹',
            onChange: function(data) {
                document.getElementById('min_price').value = data.from;
                document.getElementById('max_price').value = data.to;
                document.getElementById('slider-range-value1').textContent = '₹' + data.from.toLocaleString();
                document.getElementById('slider-range-value2').textContent = '₹' + data.to.toLocaleString();
            }
        });
    }
    
    var minInput = document.getElementById('min_price');
    var maxInput = document.getElementById('max_price');
    
    if (minInput && maxInput && slider) {
        var sliderInstance = $(slider).data('ionRangeSlider');
        
        minInput.addEventListener('change', function() {
            if (sliderInstance) {
                sliderInstance.update({
                    from: this.value
                });
            }
        });
        
        maxInput.addEventListener('change', function() {
            if (sliderInstance) {
                sliderInstance.update({
                    to: this.value
                });
            }
        });
    }
});
</script>
@endpush
@endsection