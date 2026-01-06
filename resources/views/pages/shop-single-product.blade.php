@extends('layouts.app')

@section('title', $saree->name . ' - Saree Shop')

@section('content')
<!--== Start Page Title Area ==-->
<div class="page-title-area page-title-area2">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-title-content content-style-2">
                    <div class="bread-crumbs">
                        <a href="{{ route('home') }}">Home<span class="breadcrumb-sep">></span></a>
                        @if($saree->collection)
                        <a href="{{ route('collections') }}">{{ $saree->collection->name }}<span class="breadcrumb-sep">></span></a>
                        @endif
                        <span class="active">{{ $saree->name }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--== End Page Title Area ==-->

<!--== Start Shop Area ==-->
<section class="product-area shop-single-product">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="single-product-slider">
                    <div class="product-dec-slider-right">
                        <div class="single-product-thumb">
                            <div class="single-product-thumb-slider">
                                <!-- Featured Image -->
                                @if($saree->featured_image)
                                <div class="zoom zoom-hover">
                                    <div class="thumb-item">
                                        <a class="lightbox-image" data-fancybox="gallery" href="{{ asset($saree->featured_image) }}">
                                            <img src="{{ asset($saree->featured_image) }}" alt="{{ $saree->name }}">
                                        </a>
                                    </div>
                                </div>
                                @endif

                                <!-- Gallery Images -->
                                @foreach($saree->images as $image)
                                <div class="zoom zoom-hover">
                                    <div class="thumb-item">
                                        <a class="lightbox-image" data-fancybox="gallery" href="{{ asset($image->image_path) }}">
                                            <img src="{{ asset($image->image_path) }}" alt="{{ $saree->name }}">
                                        </a>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="product-gallery-actions">
                                <a class="lightbox-image" data-fancybox="gallery" href="{{ asset($saree->featured_image) }}">
                                    <i class="lastudioicon-full-screen"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="product-dec-slider-left">
                        <div class="single-product-nav">
                            <div class="single-product-nav-slider">
                                <!-- Featured Image Thumbnail -->
                                @if($saree->featured_image)
                                <div class="nav-item">
                                    <img src="{{ asset($saree->featured_image) }}" alt="{{ $saree->name }}">
                                </div>
                                @endif

                                <!-- Gallery Images Thumbnails -->
                                @foreach($saree->images as $image)
                                <div class="nav-item">
                                    <img src="{{ asset($image->image_path) }}" alt="{{ $saree->name }}">
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="single-product-info">
                    <h4 class="title">{{ $saree->name }}</h4>
                    
                    <div class="product-rating">
                        <div class="ratting-icons">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $saree->avg_rating)
                                <i class="lastudioicon-star-rate-1"></i>
                                @else
                                <i class="lastudioicon-star-rate-2"></i>
                                @endif
                            @endfor
                        </div>
                        <div class="review">
                            <a href="#productReview">({{ $saree->total_reviews }} customer {{ $saree->total_reviews == 1 ? 'review' : 'reviews' }})</a>
                            <p>
                                <span></span>
                                @if($saree->isInStock())
                                    {{ $saree->stock_quantity }} in stock
                                @else
                                    <span class="text-danger">Out of stock</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="prices">
                        @if($saree->hasDiscount())
                            <span class="price-old">₹{{ number_format($saree->price, 2) }}</span>
                            <span class="price">₹{{ number_format($saree->sale_price, 2) }}</span>
                            <span class="badge badge-sale">-{{ $saree->getDiscountPercentage() }}%</span>
                        @else
                            <span class="price">₹{{ number_format($saree->price, 2) }}</span>
                        @endif
                    </div>

                    <p class="product-desc">{{ $saree->short_description ?? $saree->description }}</p>

                    @if($saree->isInStock())
                    <div class="quick-product-action">
                        <form action="{{ route('cart.add') }}" method="post">
                            @csrf
                            <input type="hidden" name="saree_id" value="{{ $saree->id }}">
                            <div class="action-top">
                                <div class="pro-qty-area">
                                    <div class="pro-qty">
                                        <input type="text" id="quantity1" name="quantity" title="Quantity" value="1" />
                                    </div>
                                </div>
                                <button type="submit" class="btn-theme btn-black">Add to cart</button>
                            </div>
                        </form>
                    </div>
                    @else
                    <div class="alert alert-warning">
                        This saree is currently out of stock. Please check back later.
                    </div>
                    @endif

                    <div class="product-ratting">
                        <div class="product-sku">
                            SKU: <span>{{ $saree->sku ?? 'N/A' }}</span>
                        </div>
                    </div>

                    @if($saree->collection)
                    <div class="product-categorys">
                        <div class="product-category">
                            Collection: <span>{{ $saree->collection->name }}</span>
                        </div>
                    </div>
                    @endif

                    @if(!empty($colors) && count($colors) > 0)
                    <div class="widget">
                        <h3 class="title">Colors:</h3>
                        <div class="widget-tags">
                            <ul>
                                @foreach($colors as $color)
                                <li><a href="#">{{ $color }},</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif

                    <div class="product-social-info">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank">
                            <span class="lastudioicon-b-facebook"></span>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($saree->name) }}" target="_blank">
                            <span class="lastudioicon-b-twitter"></span>
                        </a>
                        <a href="https://pinterest.com/pin/create/button/?url={{ urlencode(url()->current()) }}&description={{ urlencode($saree->name) }}" target="_blank">
                            <span class="lastudioicon-b-pinterest"></span>
                        </a>
                    </div>

                    <div class="product-nextprev">
                        @if($previousProduct ?? false)
                        <a href="{{ route('product.show', $previousProduct->slug) }}">
                            <i class="lastudioicon-arrow-left"></i>
                        </a>
                        @endif
                        @if($nextProduct ?? false)
                        <a href="{{ route('product.show', $nextProduct->slug) }}">
                            <i class="lastudioicon-arrow-right"></i>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--== End Shop Area ==-->

<!--== Start Shop Tab Area ==-->
<section class="product-area product-description-review-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="product-description-review">
                    <ul class="nav nav-tabs product-description-tab-menu" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="product-desc-tab" data-bs-toggle="tab" data-bs-target="#productDesc" type="button" role="tab" aria-controls="productDesc" aria-selected="true">Description</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="product-review-tab" data-bs-toggle="tab" data-bs-target="#productReview" type="button" role="tab" aria-controls="productReview" aria-selected="false">Reviews ({{ $saree->total_reviews }})</button>
                        </li>
                        @if($saree->care_instructions && count($saree->care_instructions) > 0)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="product-care-tab" data-bs-toggle="tab" data-bs-target="#productCare" type="button" role="tab" aria-controls="productCare" aria-selected="false">Care Instructions</button>
                        </li>
                        @endif
                        @if($saree->fabric || $saree->length || $saree->blouse_length || $saree->work_type || $saree->occasion || $saree->pattern)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="product-specs-tab" data-bs-toggle="tab" data-bs-target="#productSpecs" type="button" role="tab" aria-controls="productSpecs" aria-selected="false">Specifications</button>
                        </li>
                        @endif
                    </ul>
                    <div class="tab-content product-description-tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="productDesc" role="tabpanel" aria-labelledby="product-desc-tab">
                            <div class="product-desc">
                                <div class="product-desc-row">
                                    @if($saree->featured_image)
                                    <div class="product-thumb">
                                        <img src="{{ asset($saree->featured_image) }}" alt="{{ $saree->name }}">
                                    </div>
                                    @endif
                                    <div class="product-content">
                                        <h4>{{ $saree->name }}</h4>
                                        <p>{!! nl2br(e($saree->description)) !!}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="productReview" role="tabpanel" aria-labelledby="product-review-tab">
                            <div class="product-review">
                                <div class="product-review-comments">
                                    <h4 class="title">{{ $saree->total_reviews }} {{ $saree->total_reviews == 1 ? 'review' : 'reviews' }} for <span>{{ $saree->name }}</span></h4>
                                    
                                    @forelse($saree->approvedReviews as $review)
                                    <div class="comment-item">
                                        <div class="content">
                                            <div class="rating">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $review->rating)
                                                    <span class="lastudioicon-star-rate-1"></span>
                                                    @else
                                                    <span class="lastudioicon-star-rate-2"></span>
                                                    @endif
                                                @endfor
                                            </div>
                                            <h5 class="meta">
                                                <span>{{ $review->name }}</span> – {{ $review->created_at->format('F d, Y') }}
                                            </h5>
                                            <p class="review">{{ $review->comment }}</p>
                                        </div>
                                    </div>
                                    @empty
                                    <p>There are no reviews yet. Be the first to review this product!</p>
                                    @endforelse
                                </div>

                                <div class="product-review-form">
                                    <h3 class="title">Add a review</h3>
                                    
                                    @if(session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                    @endif

                                    @if(session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ session('error') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                    @endif

                                    @if($errors->any())
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <ul class="mb-0">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                    @endif

                                    @auth
                                    <div class="rating-input-wrapper">
                                        <span class="rating-title">Your rating *</span>
                                        <div class="rating-stars" id="rating-stars">
                                            <span class="star lastudioicon-star-rate-2" data-rating="1"></span>
                                            <span class="star lastudioicon-star-rate-2" data-rating="2"></span>
                                            <span class="star lastudioicon-star-rate-2" data-rating="3"></span>
                                            <span class="star lastudioicon-star-rate-2" data-rating="4"></span>
                                            <span class="star lastudioicon-star-rate-2" data-rating="5"></span>
                                        </div>
                                        <span class="rating-label" id="rating-label">Please select a rating</span>
                                    </div>

                                    <form action="{{ route('product.review', $saree->slug) }}" method="post" id="reviewForm">
                                        @csrf
                                        <input type="hidden" name="rating" id="rating-value" value="">
                                        <div class="review-form-content">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="reviewFormTextarea">Your review *</label>
                                                        <textarea class="form-control" id="reviewFormTextarea" name="comment" rows="7" placeholder="Write your review here..." required>{{ old('comment') }}</textarea>
                                                        <small class="form-text text-muted">Minimum 10 characters</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <button class="btn btn-theme btn-black" type="submit">Submit Review</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    @else
                                    <p>You must be <a href="{{ route('login') }}">logged in</a> to post a review.</p>
                                    @endauth
                                </div>
                            </div>
                        </div>

                        @if($saree->care_instructions && count($saree->care_instructions) > 0)
                        <div class="tab-pane fade" id="productCare" role="tabpanel" aria-labelledby="product-care-tab">
                            <div class="product-care">
                                <h4>Care Instructions</h4>
                                <ul>
                                    @foreach($saree->care_instructions as $instruction)
                                    <li>{{ $instruction }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endif

                        @if($saree->fabric || $saree->length || $saree->blouse_length || $saree->work_type || $saree->occasion || $saree->pattern)
                        <div class="tab-pane fade" id="productSpecs" role="tabpanel" aria-labelledby="product-specs-tab">
                            <div class="product-desc">
                                <div class="product-content">
                                    <h4>Product Specifications</h4>
                                    @if($saree->fabric)
                                    <p><strong>Fabric:</strong> {{ ucfirst($saree->fabric) }}</p>
                                    @endif
                                    
                                    @if($saree->length)
                                    <p><strong>Saree Length:</strong> {{ $saree->length }} meters</p>
                                    @endif
                                    
                                    @if($saree->blouse_length)
                                    <p><strong>Blouse Length:</strong> {{ $saree->blouse_length }} meters</p>
                                    @endif
                                    
                                    @if($saree->blouse_included !== null)
                                    <p><strong>Blouse:</strong> {{ $saree->blouse_included ? 'Included' : 'Not Included' }}</p>
                                    @endif
                                    
                                    @if($saree->work_type)
                                    <p><strong>Work Type:</strong> {{ ucfirst($saree->work_type) }}</p>
                                    @endif
                                    
                                    @if($saree->occasion)
                                    <p><strong>Occasion:</strong> {{ ucfirst($saree->occasion) }}</p>
                                    @endif
                                    
                                    @if($saree->pattern)
                                    <p><strong>Pattern:</strong> {{ ucfirst($saree->pattern) }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--== End Shop Tab Area ==-->

<!--== Start Products Area Wrapper ==-->
<section class="product-area related-products-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 m-auto">
                <div class="section-title text-center">
                    <h2 class="title">Related Products</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="swiper-container product4-slider-container">
                    <div class="swiper-wrapper">
                        @forelse($relatedProducts as $relatedSaree)
                        <div class="swiper-slide">
                            <div class="product-item">
                                <div class="product-thumb">
                                    <a href="{{ route('product.show', $relatedSaree->slug) }}">
                                        @php
                                            $imageUrl = $relatedSaree->featured_image 
                                                ? asset($relatedSaree->featured_image) 
                                                : asset('assets/img/shop/default.jpg');
                                        @endphp
                                        <img src="{{ $imageUrl }}" alt="{{ $relatedSaree->name }}">
                                        <span class="thumb-overlay"></span>
                                    </a>
                                    @if($relatedSaree->hasDiscount())
                                    <span class="badge">-{{ $relatedSaree->getDiscountPercentage() }}%</span>
                                    @endif
                                    <div class="product-action action-style3">
                                        <a class="action-cart ht-tooltip" data-tippy-content="Add to cart" href="{{ route('cart') }}" title="Add to cart">
                                            <i class="lastudioicon-shopping-cart-3"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="product-info info-style3">
                                    <div class="content-inner">
                                        <h4 class="title"><a href="{{ route('product.show', $relatedSaree->slug) }}">{{ $relatedSaree->name }}</a></h4>
                                        <div class="prices">
                                            @if($relatedSaree->hasDiscount())
                                                <span class="price-old">₹{{ number_format($relatedSaree->price, 2) }}</span>
                                                <span class="price">₹{{ number_format($relatedSaree->sale_price, 2) }}</span>
                                            @else
                                                <span class="price">₹{{ number_format($relatedSaree->price, 2) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12 text-center">
                            <p>No related products found.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--== End Products Area Wrapper ==-->

@push('scripts')
<script>
// Star rating functionality
document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('#rating-stars .star');
    const ratingInput = document.getElementById('rating-value');
    const ratingLabel = document.getElementById('rating-label');
    const reviewForm = document.getElementById('reviewForm');
    
    if (stars.length > 0 && ratingInput) {
        const ratingLabels = [
            'Please select a rating',
            'Poor',
            'Fair',
            'Good',
            'Very Good',
            'Excellent'
        ];
        
        // Click handler for stars
        stars.forEach((star, index) => {
            star.addEventListener('click', function() {
                const rating = parseInt(this.getAttribute('data-rating'));
                ratingInput.value = rating;
                
                // Update star display
                updateStars(rating);
                
                // Update label
                ratingLabel.textContent = ratingLabels[rating];
                ratingLabel.style.color = '#d4af37';
            });
            
            // Hover effect
            star.addEventListener('mouseenter', function() {
                const rating = parseInt(this.getAttribute('data-rating'));
                updateStars(rating, true);
            });
        });
        
        // Reset to selected rating on mouse leave
        document.getElementById('rating-stars').addEventListener('mouseleave', function() {
            const currentRating = parseInt(ratingInput.value) || 0;
            updateStars(currentRating);
        });
        
        function updateStars(rating, isHover = false) {
            stars.forEach((star, index) => {
                const starRating = parseInt(star.getAttribute('data-rating'));
                
                if (starRating <= rating) {
                    star.classList.remove('lastudioicon-star-rate-2');
                    star.classList.add('lastudioicon-star-rate-1');
                    if (isHover) {
                        star.classList.add('hover');
                    } else {
                        star.classList.remove('hover');
                    }
                } else {
                    star.classList.remove('lastudioicon-star-rate-1', 'hover');
                    star.classList.add('lastudioicon-star-rate-2');
                }
            });
        }
        
        // Form validation
        if (reviewForm) {
            reviewForm.addEventListener('submit', function(e) {
                if (!ratingInput.value) {
                    e.preventDefault();
                    alert('Please select a rating before submitting your review.');
                    ratingLabel.textContent = 'Please select a rating';
                    ratingLabel.style.color = '#dc3545';
                    return false;
                }
            });
        }
    }
});
</script>
@endpush

@endsection

<style>
.prices {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 20px;
}

.price-old {
    text-decoration: line-through;
    color: #999;
    font-size: 18px;
    font-weight: 400;
}

.price {
    color: #000;
    font-size: 28px;
    font-weight: 600;
}

.badge-sale {
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

/* Product Description Image Size Control */
.product-desc .product-thumb {
    max-width: 300px;
    margin-right: 30px;
    flex-shrink: 0;
}

.product-desc .product-thumb img {
    width: 100%;
    height: auto;
    border-radius: 8px;
    object-fit: cover;
}

.product-desc .product-desc-row {
    display: flex;
    gap: 30px;
    align-items: flex-start;
}

.product-desc .product-content {
    flex: 1;
}

@media (max-width: 768px) {
    .product-desc .product-desc-row {
        flex-direction: column;
    }
    
    .product-desc .product-thumb {
        max-width: 100%;
        margin-right: 0;
        margin-bottom: 20px;
    }
}

/* Review Star Rating Styles */
.rating-input-wrapper {
    margin-bottom: 20px;
}

.rating-title {
    display: block;
    margin-bottom: 10px;
    font-weight: 600;
    color: #333;
}

.rating-stars {
    display: flex;
    gap: 5px;
    margin-bottom: 8px;
}

.rating-stars .star {
    font-size: 24px;
    cursor: pointer;
    transition: all 0.2s ease;
    color: #ddd;
}

.rating-stars .star:hover,
.rating-stars .star.hover {
    transform: scale(1.1);
}

.rating-stars .star.lastudioicon-star-rate-1 {
    color: #d4af37;
}

.rating-label {
    display: block;
    font-size: 14px;
    color: #666;
    font-style: italic;
}

.alert {
    margin-bottom: 20px;
}

.form-control:focus {
    border-color: #d4af37;
    box-shadow: 0 0 0 0.2rem rgba(212, 175, 55, 0.25);
}

.product-review-form .form-group {
    margin-bottom: 20px;
}

.product-review-form label {
    font-weight: 600;
    margin-bottom: 8px;
    display: block;
}

.product-review-comments .comment-item {
    margin-bottom: 30px;
    padding-bottom: 30px;
    border-bottom: 1px solid #eee;
}

.product-review-comments .comment-item:last-child {
    border-bottom: none;
}
</style>