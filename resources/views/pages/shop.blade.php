@extends('layouts.app')

@section('title', 'Shop Sarees - Clothing Shop')

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

                    {{-- Collections Widget --}}
                    <div class="widget">
                        <h3 class="widget-title">Collections</h3>
                        <div class="widget-custom-menu">
                            <ul>
                                <li class="{{ !request('collection') ? 'active' : '' }}">
                                    <a href="{{ route('shop') }}">All Collections</a>
                                </li>
                                @foreach($collections as $collection)
                                <li class="{{ request('collection') == $collection->id ? 'active' : '' }}">
                                    <a href="{{ route('shop', ['collection' => $collection->id]) }}">
                                        {{ $collection->name }}
                                    </a>
                                </li>
                                @endforeach
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
                            <a class="btn-filter" href="shop.html">Filter</a>
                        </div>
                    </div>

                    {{-- Fabric Filter Widget --}}
                    @if($fabrics->count() > 0)
                    <div class="widget">
                        <h4 class="widget-title">By Fabric</h4>
                        <div class="widget-size-menu">
                            <ul>
                                @foreach($fabrics as $fabric)
                                <li class="{{ request('fabric') == $fabric ? 'active' : '' }}">
                                    <a href="{{ route('shop', array_merge(request()->except('fabric'), ['fabric' => $fabric])) }}">
                                        {{ $fabric }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif

                    {{-- Occasion Filter Widget --}}
                    @if($occasions->count() > 0)
                    <div class="widget">
                        <h4 class="widget-title">By Occasion</h4>
                        <div class="widget-size-menu">
                            <ul>
                                @foreach($occasions as $occasion)
                                <li class="{{ request('occasion') == $occasion ? 'active' : '' }}">
                                    <a href="{{ route('shop', array_merge(request()->except('occasion'), ['occasion' => $occasion])) }}">
                                        {{ $occasion }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif

                    {{-- Work Type Filter Widget --}}
                    @if($workTypes->count() > 0)
                    <div class="widget">
                        <h4 class="widget-title">By Work Type</h4>
                        <div class="widget-size-menu">
                            <ul>
                                @foreach($workTypes as $workType)
                                <li class="{{ request('work_type') == $workType ? 'active' : '' }}">
                                    <a href="{{ route('shop', array_merge(request()->except('work_type'), ['work_type' => $workType])) }}">
                                        {{ $workType }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif

                    {{-- Clear Filters --}}
                    @if(count(request()->except('page')) > 0)   
                    <div class="widget">
                        <a href="{{ route('shop') }}" class="btn-theme btn-black btn-border w-100">Clear All Filters</a>
                    </div>
                    @endif
                </div>
            </div>

            <div class="col-lg-9 order-0 order-lg-1">
                <div class="inner-left-padding">
                    {{-- Shop Toolbar --}}
                    <div class="shop-toolbar-wrap">
                        <div class="shop-toolbar-left">
                            <div class="product-showing-status">
                                <p class="count-result">Showing {{ $sarees->firstItem() ?? 0 }}–{{ $sarees->lastItem() ?? 0 }} of {{ $sarees->total() }} results</p>
                            </div>
                        </div>
                        <div class="shop-toolbar-right">
                            <div class="product-sorting-menu product-view-count">
                                <span class="current">Show {{ request('per_page', 12) }} <i class="lastudioicon-down-arrow"></i></span>
                                <ul>
                                    <li class="{{ request('per_page') == 12 || !request('per_page') ? 'active' : '' }}">
                                        <a href="{{ route('shop', array_merge(request()->except('per_page'), ['per_page' => 12])) }}" class="{{ request('per_page') == 12 || !request('per_page') ? 'active' : '' }}">Show 12</a>
                                    </li>
                                    <li class="{{ request('per_page') == 15 ? 'active' : '' }}">
                                        <a href="{{ route('shop', array_merge(request()->except('per_page'), ['per_page' => 15])) }}">Show 15</a>
                                    </li>
                                    <li class="{{ request('per_page') == 30 ? 'active' : '' }}">
                                        <a href="{{ route('shop', array_merge(request()->except('per_page'), ['per_page' => 30])) }}">Show 30</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="product-sorting-menu product-sorting">
                                <span class="current">
                                    @switch(request('sort', 'default'))
                                        @case('popularity') Sort by Popularity @break
                                        @case('rating') Sort by Rated @break
                                        @case('latest') Sort by Latest @break
                                        @case('price_low') Sort by Price: <i class="lastudioicon-arrow-up"></i> @break
                                        @case('price_high') Sort by Price: <i class="lastudioicon-arrow-down"></i> @break
                                        @default Sort by Default
                                    @endswitch
                                    <i class="lastudioicon-down-arrow"></i>
                                </span>
                                <ul>
                                    <li class="{{ request('sort') == 'default' || !request('sort') ? 'active' : '' }}">
                                        <a href="{{ route('shop', array_merge(request()->except('sort'), ['sort' => 'default'])) }}" class="{{ request('sort') == 'default' || !request('sort') ? 'active' : '' }}">Sort by Default</a>
                                    </li>
                                    <li class="{{ request('sort') == 'popularity' ? 'active' : '' }}">
                                        <a href="{{ route('shop', array_merge(request()->except('sort'), ['sort' => 'popularity'])) }}">Sort by Popularity</a>
                                    </li>
                                    <li class="{{ request('sort') == 'rating' ? 'active' : '' }}">
                                        <a href="{{ route('shop', array_merge(request()->except('sort'), ['sort' => 'rating'])) }}">Sort by Rated</a>
                                    </li>
                                    <li class="{{ request('sort') == 'latest' ? 'active' : '' }}">
                                        <a href="{{ route('shop', array_merge(request()->except('sort'), ['sort' => 'latest'])) }}">Sort by Latest</a>
                                    </li>
                                    <li class="{{ request('sort') == 'price_low' ? 'active' : '' }}">
                                        <a href="{{ route('shop', array_merge(request()->except('sort'), ['sort' => 'price_low'])) }}">Sort by Price: <i class="lastudioicon-arrow-up"></i></a>
                                    </li>
                                    <li class="{{ request('sort') == 'price_high' ? 'active' : '' }}">
                                        <a href="{{ route('shop', array_merge(request()->except('sort'), ['sort' => 'price_high'])) }}">Sort by Price: <i class="lastudioicon-arrow-down"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    {{-- Products Grid --}}
                    <div class="row row-gutter-60 product-items-style4">
                        @forelse($sarees as $saree)
                        <div class="col-sm-6 col-md-4">
                            <!-- Start Product Item -->
                            <div class="product-item">
                                <div class="product-thumb">
                                    <a href="{{ route('product.show', $saree->slug) }}">
                                        <img src="{{ $saree->featured_image ? asset('storage/' . $saree->featured_image) : asset('assets/img/shop/default.jpg') }}" alt="{{ $saree->name }}">
                                        <span class="thumb-overlay"></span>
                                    </a>
                                    @if($saree->hasDiscount())
                                    <span class="badge">-{{ $saree->getDiscountPercentage() }}%</span>
                                    @endif
                                    @if($saree->is_new_arrival)
                                    <span class="badge badge-new">NEW</span>
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
                            <p>Try adjusting your filters or search criteria</p>
                            <a href="{{ route('shop') }}" class="btn-theme btn-black btn-border mt-3">Clear Filters</a>
                        </div>
                        @endforelse
                    </div>

                    {{-- Pagination --}}
                    @if($sarees->hasPages())
                    <div class="pagination-area">
                        <nav>
                            <ul class="page-numbers">
                                {{-- Previous Page Link --}}
                                @if ($sarees->onFirstPage())
                                    <li><span class="page-number disabled">«</span></li>
                                @else
                                    <li><a class="page-number" href="{{ $sarees->previousPageUrl() }}">«</a></li>
                                @endif

                                {{-- Pagination Elements --}}
                                @foreach ($sarees->links()->elements[0] as $page => $url)
                                    @if ($page == $sarees->currentPage())
                                        <li><a class="page-number active" href="#">{{ $page }}</a></li>
                                    @else
                                        <li><a class="page-number" href="{{ $url }}">{{ $page }}</a></li>
                                    @endif
                                @endforeach

                                {{-- Next Page Link --}}
                                @if ($sarees->hasMorePages())
                                    <li><a class="page-number next" href="{{ $sarees->nextPageUrl() }}"><i class="icofont-long-arrow-right"></i></a></li>
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
<!--== End Product Area Wrapper ==-->

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Price range slider initialization
    const minPrice = {{ $priceRange['min'] }};
    const maxPrice = {{ $priceRange['max'] }};
    const currentMin = {{ request('min_price', $priceRange['min']) }};
    const currentMax = {{ request('max_price', $priceRange['max']) }};
    
    // Initialize range slider (assuming rangeSlider.js is loaded from template)
    if (typeof $.fn.rangeSlider !== 'undefined') {
        $('#slider-range').rangeSlider({
            min: minPrice,
            max: maxPrice,
            from: currentMin,
            to: currentMax,
            type: 'double',
            prefix: '₹',
            onChange: function(data) {
                $('#slider-range-value1').text('₹' + data.from);
                $('#slider-range-value2').text('₹' + data.to);
            }
        });
        
        // Initial values
        $('#slider-range-value1').text('₹' + currentMin);
        $('#slider-range-value2').text('₹' + currentMax);
        
        // Filter button click
        $('.btn-filter').on('click', function(e) {
            e.preventDefault();
            const sliderData = $('#slider-range').data('ionRangeSlider');
            if (sliderData) {
                const minVal = sliderData.result.from;
                const maxVal = sliderData.result.to;
                
                // Build URL with all current parameters
                let url = new URL(window.location.href);
                url.searchParams.set('min_price', minVal);
                url.searchParams.set('max_price', maxVal);
                
                window.location.href = url.toString();
            }
        });
    }
});
</script>
@endpush
@endsection