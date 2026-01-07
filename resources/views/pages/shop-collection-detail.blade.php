{{-- File: resources/views/pages/shop-collection-detail.blade.php --}}
@extends('layouts.app')

@section('title', $collection->name . ' - Saree Collection')

@push('styles')
<style>
/* Collection Banner */
.collection-banner {
    position: relative;
    height: 400px;
    background-size: cover;
    background-position: center;
    margin-bottom: 60px;
}

.collection-banner::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(to bottom, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0.6) 100%);
}

.collection-banner-content {
    position: relative;
    z-index: 2;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    color: #fff;
    padding: 40px 20px;
}

.collection-banner-title {
    font-size: 48px;
    font-weight: 700;
    margin-bottom: 15px;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
}

.collection-banner-description {
    font-size: 18px;
    max-width: 700px;
    line-height: 1.6;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
}

/* Product Grid Styling */
.product-items-style4 .product-thumb {
    position: relative;
    overflow: hidden;
    padding-bottom: 125%;
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
}
</style>
@endpush

@section('content')
<section class="page-title-area bg-img" data-bg-img="{{ $collection->banner_image ? asset($collection->banner_image) : asset('assets/img/photos/bg-page1.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-title-content">
                    <h2 class="title">{{ $collection->name }}</h2>
                    <div class="bread-crumbs">
                        <a href="{{ route('home') }}">Home<span class="breadcrumb-sep">></span></a>
                        <a href="{{ route('collections') }}">Collections<span class="breadcrumb-sep">></span></a>
                        <span class="active">{{ $collection->name }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@if($collection->description)
<section style="padding: 40px 0; background: #f8f9fa;">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <p style="font-size: 16px; line-height: 1.8; color: #666;">{{ $collection->description }}</p>
            </div>
        </div>
    </div>
</section>
@endif

<section class="product-area" style="padding: 60px 0;">
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
                            <p class="count-result">Showing {{ $firstItem }}–{{ $lastItem }} of {{ $total }} sarees</p>
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
                                    <a href="{{ route('collections.show', array_merge(['slug' => $collection->slug], request()->except('page'), ['per_page' => 12])) }}">Show 12</a>
                                </li>
                                <li class="{{ $perPage == 15 ? 'active' : '' }}">
                                    <a href="{{ route('collections.show', array_merge(['slug' => $collection->slug], request()->except('page'), ['per_page' => 15])) }}">Show 15</a>
                                </li>
                                <li class="{{ $perPage == 30 ? 'active' : '' }}">
                                    <a href="{{ route('collections.show', array_merge(['slug' => $collection->slug], request()->except('page'), ['per_page' => 30])) }}">Show 30</a>
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
                                    <a href="{{ route('collections.show', array_merge(['slug' => $collection->slug], request()->except('page'), ['sort' => 'default'])) }}">Sort by Default</a>
                                </li>
                                <li class="{{ $sortType == 'popularity' ? 'active' : '' }}">
                                    <a href="{{ route('collections.show', array_merge(['slug' => $collection->slug], request()->except('page'), ['sort' => 'popularity'])) }}">Sort by Popularity</a>
                                </li>
                                <li class="{{ $sortType == 'rating' ? 'active' : '' }}">
                                    <a href="{{ route('collections.show', array_merge(['slug' => $collection->slug], request()->except('page'), ['sort' => 'rating'])) }}">Sort by Rated</a>
                                </li>
                                <li class="{{ $sortType == 'latest' ? 'active' : '' }}">
                                    <a href="{{ route('collections.show', array_merge(['slug' => $collection->slug], request()->except('page'), ['sort' => 'latest'])) }}">Sort by Latest</a>
                                </li>
                                <li class="{{ $sortType == 'price_low' ? 'active' : '' }}">
                                    <a href="{{ route('collections.show', array_merge(['slug' => $collection->slug], request()->except('page'), ['sort' => 'price_low'])) }}">Sort by Price: Low to High</a>
                                </li>
                                <li class="{{ $sortType == 'price_high' ? 'active' : '' }}">
                                    <a href="{{ route('collections.show', array_merge(['slug' => $collection->slug], request()->except('page'), ['sort' => 'price_high'])) }}">Sort by Price: High to Low</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="row row-gutter-60 product-items-style4">
                    @forelse($sarees as $saree)
                    <div class="col-sm-6 col-md-4 col-lg-3">
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
                        <h3>No sarees found in this collection</h3>
                        <p>Check back soon for new arrivals!</p>
                        <a href="{{ route('collections') }}" class="btn-theme btn-black btn-border mt-3">View All Collections</a>
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
</section>
@endsection