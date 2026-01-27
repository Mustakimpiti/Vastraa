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

                <!-- Updated Product Grid - Same Style as Home Page -->
                <div class="row row-gutter-60">
                    @forelse($sarees as $saree)
                    <div class="col-sm-6 col-lg-4">
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
                                <span class="badge">-{{ $saree->getDiscountPercentage() }}%</span>
                                @endif
                                @if($saree->is_new_arrival)
                                <span class="badge badge-new">NEW</span>
                                @endif
                                <div class="product-action">
                                    <a class="action-quick-view ht-tooltip" data-tippy-content="Quick View" href="javascript:void(0);" title="Quick View"
                                       onclick="showQuickView({{ $saree->id }}, '{{ addslashes($saree->name) }}', '{{ $imageUrl }}', '{{ $saree->hasDiscount() ? number_format($saree->sale_price, 2) : number_format($saree->price, 2) }}', '{{ $saree->hasDiscount() ? number_format($saree->price, 2) : '' }}', '{{ $saree->stock_quantity }}', '{{ addslashes($saree->short_description ?? $saree->description) }}', '{{ $saree->sku ?? 'N/A' }}', '{{ route('product.show', $saree->slug) }}', '{{ $saree->hasDiscount() ? $saree->getDiscountPercentage() : '' }}', {{ $saree->avg_rating ?? 0 }}, {{ $saree->total_reviews ?? 0 }})">
                                        <i class="lastudioicon-search-zoom-in"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="product-info">
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
                                    @if($saree->avg_rating > 0)
                                    <div class="rating">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $saree->avg_rating)
                                            <i class="lastudioicon-star-rate"></i>
                                            @else
                                            <i class="lastudioicon-star-rate-empty"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    @endif
                                </div>
                                <div class="product-info-action">
                                    <form action="{{ route('cart.add') }}" method="POST" style="display: inline;">
                                        @csrf
                                        <input type="hidden" name="saree_id" value="{{ $saree->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="action-cart ht-tooltip" data-tippy-content="Add to cart" title="Add to cart" style="background: none; border: none; cursor: pointer;">
                                            <i class="lastudioicon-bag-3"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
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

@endsection

@push('scripts')
<script>
function showQuickView(id, name, image, price, oldPrice, stock, description, sku, productUrl, discount, rating, totalReviews) {
    // Update product image
    const modalImage = document.querySelector('.product-quick-view-modal .thumb img');
    if (modalImage) {
        modalImage.src = image;
        modalImage.alt = name;
    }
    
    // Update product title
    const modalTitle = document.querySelector('.product-quick-view-modal .title');
    if (modalTitle) {
        modalTitle.textContent = name;
    }
    
    // Update rating
    const ratingDiv = document.querySelector('.product-quick-view-modal .ratting-icons');
    if (ratingDiv) {
        let ratingHtml = '';
        for (let i = 1; i <= 5; i++) {
            if (i <= rating) {
                ratingHtml += '<i class="lastudioicon-star-rate-1"></i>';
            } else {
                ratingHtml += '<i class="lastudioicon-star-rate-2"></i>';
            }
        }
        ratingDiv.innerHTML = ratingHtml;
    }
    
    // Update review count
    const reviewLink = document.querySelector('.product-quick-view-modal .review a');
    if (reviewLink) {
        reviewLink.textContent = '(' + totalReviews + ' customer ' + (totalReviews == 1 ? 'review' : 'reviews') + ')';
        reviewLink.href = productUrl + '#productReview';
    }
    
    // Update stock info
    const stockInfo = document.querySelector('.product-quick-view-modal .review p');
    if (stockInfo) {
        if (stock > 0) {
            stockInfo.innerHTML = '<span></span>' + stock + ' in stock';
        } else {
            stockInfo.innerHTML = '<span class="text-danger">Out of stock</span>';
        }
    }
    
    // Update prices with discount badge
    const pricesDiv = document.querySelector('.product-quick-view-modal .prices');
    if (pricesDiv) {
        if (oldPrice && discount) {
            pricesDiv.innerHTML = '<span class="price-old">₹' + oldPrice + '</span><span class="price">₹' + price + '</span><span class="badge badge-sale">-' + discount + '%</span>';
        } else {
            pricesDiv.innerHTML = '<span class="price">₹' + price + '</span>';
        }
    }
    
    // Update description
    const descDiv = document.querySelector('.product-quick-view-modal .product-desc');
    if (descDiv) {
        const shortDesc = description.length > 200 ? description.substring(0, 200) + '...' : description;
        descDiv.textContent = shortDesc;
    }
    
    // Update SKU
    const skuSpan = document.querySelector('.product-quick-view-modal .product-sku span');
    if (skuSpan) {
        skuSpan.textContent = sku;
    }
    
    // Hide original add to cart section and other action buttons
    const addToCartSection = document.querySelector('.product-quick-view-modal .quick-product-action');
    if (addToCartSection) {
        addToCartSection.style.display = 'none';
    }
    
    const actionBottom = document.querySelector('.product-quick-view-modal .action-bottom');
    if (actionBottom) {
        actionBottom.style.display = 'none';
    }
    
    // Find or create button container after product description
    let buttonContainer = document.querySelector('.product-quick-view-modal .quick-view-custom-buttons');
    
    if (!buttonContainer) {
        buttonContainer = document.createElement('div');
        buttonContainer.className = 'quick-view-custom-buttons';
        
        // Try multiple locations to insert buttons
        const productDesc = document.querySelector('.product-quick-view-modal .product-desc');
        const productInfo = document.querySelector('.product-quick-view-modal .product-info');
        const singleProductInfo = document.querySelector('.product-quick-view-modal .single-product-info');
        const contentWrap = document.querySelector('.product-quick-view-modal .content-wrap');
        const modalContent = document.querySelector('.product-quick-view-modal .modal-content');
        
        if (productDesc && productDesc.parentNode) {
            productDesc.parentNode.insertBefore(buttonContainer, productDesc.nextSibling);
        } else if (singleProductInfo) {
            singleProductInfo.appendChild(buttonContainer);
        } else if (productInfo) {
            productInfo.appendChild(buttonContainer);
        } else if (contentWrap) {
            contentWrap.appendChild(buttonContainer);
        } else if (modalContent) {
            modalContent.appendChild(buttonContainer);
        }
    }
    
    // Clear existing buttons
    buttonContainer.innerHTML = '';
    
    // Create buttons HTML
    let buttonsHtml = '';
    
    if (stock > 0) {
        // Add to Cart Button
        buttonsHtml += `
            <form action="{{ route('cart.add') }}" method="POST" style="display: inline-block; flex: 1; min-width: 200px;">
                @csrf
                <input type="hidden" name="saree_id" value="${id}">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="btn-theme btn-black" style="width: 100%;">
                    <i class="lastudioicon-bag-3"></i> Add to Cart
                </button>
            </form>
        `;
    }
    
    // View Details Button
    buttonsHtml += `
        <a href="${productUrl}" class="btn-theme btn-border btn-black" style="flex: 1; min-width: 200px;">
            <i class="lastudioicon-search-zoom-in"></i> View Details
        </a>
    `;
    
    buttonContainer.innerHTML = buttonsHtml;
    buttonContainer.style.display = 'flex';
    buttonContainer.style.visibility = 'visible';
    buttonContainer.style.opacity = '1';
    
    // Show modal
    const modal = document.querySelector('.product-quick-view-modal');
    const overlay = document.querySelector('.canvas-overlay');
    
    if (modal) {
        modal.classList.add('open');
    }
    if (overlay) {
        overlay.classList.add('open');
    }
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

/* Hide original add to cart and action sections */
.product-quick-view-modal .quick-product-action {
    display: none !important;
}

.product-quick-view-modal .action-bottom {
    display: none !important;
}

/* Custom Quick View Buttons Container - FORCE DISPLAY */
.quick-view-custom-buttons {
    display: flex !important;
    visibility: visible !important;
    opacity: 1 !important;
    gap: 15px;
    margin-top: 30px !important;
    padding-top: 25px;
    border-top: 1px solid #e5e5e5;
    flex-wrap: wrap;
    width: 100%;
    position: relative;
    z-index: 10;
}

.quick-view-custom-buttons form {
    flex: 1;
    min-width: 200px;
    display: inline-block !important;
    margin: 0;
}

.quick-view-custom-buttons a {
    flex: 1;
    min-width: 200px;
    display: inline-flex !important;
}

.quick-view-custom-buttons .btn-theme {
    width: 100%;
    padding: 14px 30px;
    font-size: 15px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-radius: 0;
    transition: all 0.3s ease;
    display: inline-flex !important;
    align-items: center;
    justify-content: center;
    gap: 8px;
    border: 2px solid #000;
    text-decoration: none;
    cursor: pointer;
    line-height: 1.5;
}

.quick-view-custom-buttons .btn-black {
    background-color: #000;
    color: #fff !important;
}

.quick-view-custom-buttons .btn-black:hover {
    background-color: #fff;
    color: #000 !important;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.quick-view-custom-buttons .btn-border {
    background-color: transparent;
    color: #000 !important;
}

.quick-view-custom-buttons .btn-border:hover {
    background-color: #000;
    color: #fff !important;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.quick-view-custom-buttons i {
    font-size: 16px;
}

.quick-view-custom-buttons button[type="submit"] {
    cursor: pointer;
}

/* Out of stock styling */
.product-quick-view-modal .text-danger {
    color: #dc3545;
    font-weight: 600;
}

/* Responsive Styles */
@media (max-width: 767px) {
    .quick-view-custom-buttons {
        flex-direction: column;
        gap: 12px;
    }
    
    .quick-view-custom-buttons form,
    .quick-view-custom-buttons a {
        min-width: 100%;
    }
    
    .quick-view-custom-buttons .btn-theme {
        padding: 12px 20px;
        font-size: 14px;
    }
}

@media (min-width: 768px) and (max-width: 991px) {
    .quick-view-custom-buttons .btn-theme {
        padding: 13px 25px;
        font-size: 14px;
    }
}
</style>
@endpush