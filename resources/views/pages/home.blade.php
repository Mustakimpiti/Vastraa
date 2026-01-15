@extends('layouts.app')

@section('title', 'Home - Clothing Shop')

@section('content')
<!--== Start Hero Area Wrapper ==-->
<section class="home-slider-area slider-default">
    <div class="home-slider-content">
        <div class="swiper-container home-slider-container">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="home-slider-item">
                        <div class="bg-thumb bg-overlay bg-img" data-bg-img="{{ asset('assets/img/slider/h1-s1.jpg') }}"></div>
                        <div class="slider-content-area">
                            <div class="container">
                                <div class="row align-items-center">
                                    <div class="col-md-8 col-lg-5 m-auto">
                                        <div class="content">
                                            <div class="inner-content">
                                                <h2 style="font-size: 2.5rem;">EVERY DRAPE WHISPERS</h2>
                                                <p style="font-size: 0.95rem;">Grace wrapped in tradition. A saree is poetry woven in threads, turning traditions into trends with unstoppable spirit.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="home-slider-item">
                        <div class="bg-thumb bg-overlay bg-img" data-bg-img="{{ asset('assets/img/slider/h1-s2.jpg') }}"></div>
                        <div class="slider-content-area">
                            <div class="container">
                                <div class="row align-items-center">
                                    <div class="col-md-8 col-lg-5 m-auto">
                                        <div class="content">
                                            <div class="inner-content">
                                                <h2 style="font-size: 2.5rem;">SAREE SWAG, UNSTOPPABLE SPIRIT</h2>
                                                <p style="font-size: 0.95rem;">Not just fabric, it's heritage. Grace in folds, strength in spirit. Saree: it's my statement.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="home-slider-item">
                        <div class="bg-thumb bg-overlay bg-img" data-bg-img="{{ asset('assets/img/slider/h1-s3.jpg') }}"></div>
                        <div class="slider-content-area">
                            <div class="container">
                                <div class="row align-items-center">
                                    <div class="col-md-8 col-lg-5 m-auto">
                                        <div class="content">
                                            <div class="inner-content">
                                                <h2 style="font-size: 2.5rem;">SAREE, BUT MAKE IT SAVAGE</h2>
                                                <p style="font-size: 0.95rem;">Turning traditions into trends. Every thread tells a story of grace, elegance, and timeless beauty.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>
<!--== End Hero Area Wrapper ==-->

<!--== Start Collection Slider Area Wrapper ==-->
<section class="collection-slider-area">
    <div class="collection-slider-content">
        <div class="swiper-container collection-slider-container">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="slider-item">
                        <div class="thumb">
                            <div class="bg-thumb bg-overlay bg-img" data-bg-img="{{ asset('assets/img/about/2.JPG') }}"></div>
                        </div>
                        <div class="slider-content-area">
                            <div class="content">
                                <div class="inner-content">
                                    <span>Heritage Collection 2024</span>
                                    <h2 style="font-size: 2rem;">A Saree is Poetry Woven in Threads</h2>
                                    <p style="font-size: 0.9rem;">Discover our exclusive collection where tradition meets contemporary elegance. Each saree is carefully curated to embody grace in folds and strength in spirit.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--== End Collection Slider Area Wrapper ==-->

<!--== Start Products Area Wrapper (Best Sellers) ==-->
<section class="product-area new-product-area">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-lg-6 m-auto">
                <div class="section-title text-center" data-aos="fade-up" data-aos-duration="1000">
                    <h2 class="title">New Products</h2>
                    <h5 class="subtitle">COLLECTION</h5>
                </div>
            </div>
        </div>
        <div class="row row-gutter-60" data-aos="fade-up" data-aos-duration="1000">
            @forelse($bestSellers as $saree)
            <div class="col-sm-6 col-lg-4">
                <div class="product-item">
                    <div class="product-thumb">
                        <a href="{{ route('product.show', $saree->slug) }}">
                            <img src="{{ $saree->featured_image ? asset($saree->featured_image) : asset('assets/img/shop/default.jpg') }}" alt="{{ $saree->name }}">
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
                               onclick="showQuickView({{ $saree->id }}, '{{ addslashes($saree->name) }}', '{{ $saree->featured_image ? asset($saree->featured_image) : asset('assets/img/shop/default.jpg') }}', '{{ $saree->hasDiscount() ? number_format($saree->sale_price, 2) : number_format($saree->price, 2) }}', '{{ $saree->hasDiscount() ? number_format($saree->price, 2) : '' }}', '{{ $saree->stock_quantity }}', '{{ addslashes($saree->short_description ?? $saree->description) }}', '{{ $saree->sku ?? 'N/A' }}', '{{ route('product.show', $saree->slug) }}', '{{ $saree->hasDiscount() ? $saree->getDiscountPercentage() : '' }}', {{ $saree->avg_rating ?? 0 }}, {{ $saree->total_reviews ?? 0 }})">
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
            <div class="col-md-12 text-center">
                <p>No sarees available at the moment. Please check back soon!</p>
            </div>
            @endforelse
        </div>
    </div>
</section>
<!--== End Products Area Wrapper ==-->

<!--== Start Divider Area Wrapper ==-->
<section class="divider-area bg-overlay2 bg-img" data-bg-img="assets/img/photos/bg-d1.jpg">
    <div class="container">
        <div class="row">
            <div class="col-xl-8 col-lg-12 m-auto">
                <div class="divider-content divider-content-style1" data-aos="fade-up" data-aos-duration="1000">
                    <h2>Are you tired of <br> all those ordinary sarees?</h2>
                    <p>We invite you to step into our creative and imaginative world,<br> where sarees can be as elegant and traditional as they are modern and breathtaking.</p>
                    <a href="{{ route('shop') }}" class="btn-theme btn-white">New Arrivals</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!--== End Divider Area Wrapper ==-->

<!--== Start Blog Area Wrapper ==-->
<section class="blog-area blog-about-area">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-lg-6 m-auto">
                <div class="section-title text-center" data-aos="fade-up" data-aos-duration="1000">
                    <h2 class="title">#Our Latest News</h2>
                </div>
            </div>
        </div>
        <div class="row post-items" data-aos="fade-up" data-aos-duration="1200">
            <div class="col-12">
                <div class="swiper-container post-slider-container">
                    <div class="swiper-wrapper">
                        @forelse($recentBlogs as $blog)
                        <div class="swiper-slide">
                            <div class="post-item">
                                <div class="thumb">
                                    <a href="{{ route('blog.show', $blog->slug) }}">
                                        <img src="{{ $blog->featured_image ? asset($blog->featured_image) : asset('assets/img/blog/s1.jpg') }}" 
                                             alt="{{ $blog->title }}">
                                    </a>
                                </div>
                                <div class="content">
                                    <div class="post-meta">
                                        @if($blog->author_image)
                                            <img src="{{ asset($blog->author_image) }}" alt="{{ $blog->author_name }}">
                                        @else
                                            <img src="{{ asset('assets/img/icons/s1.jpg') }}" alt="{{ $blog->author_name }}">
                                        @endif
                                        <a href="#">{{ $blog->author_name }}</a>
                                    </div>
                                    <div class="inner-content">
                                        <h4 class="title">
                                            <a href="{{ route('blog.show', $blog->slug) }}">{{ $blog->title }}</a>
                                        </h4>
                                        <p>{{ Str::limit($blog->excerpt, 120) }}</p>
                                    </div>
                                    <a href="{{ route('blog.show', $blog->slug) }}" class="btn-theme btn-border btn-black">Continue reading</a>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="swiper-slide">
                            <div class="post-item">
                                <div class="thumb">
                                    <a href="#"><img src="{{ asset('assets/img/blog/s1.jpg') }}" alt="Moren-Image"></a>
                                </div>
                                <div class="content">
                                    <div class="post-meta">
                                        <img src="{{ asset('assets/img/icons/s1.jpg') }}" alt="Image">
                                        <a href="#">Admin</a>
                                    </div>
                                    <div class="inner-content">
                                        <h4 class="title">
                                            <a href="#">No blog posts yet</a>
                                        </h4>
                                        <p>Check back soon for exciting updates and stories about our saree collection.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforelse
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--== End Blog Area Wrapper ==-->
<!--== Start Newsletter Area ==-->
<section class="newsletter-area bg-overlay-black2-6 bg-parallax" data-speed="1.136" data-bg-img="assets/img/photos/bg-d4.jpg">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 m-auto">
                <div class="newsletter-content content-style3" data-aos="fade-up" data-aos-duration="1000">
                    <h1 class="title">Stay in the loop</h1>
                    <p>Sign up for our newsletter to be updated with the latest products and news.</p>
                    
                    {{-- Success Message --}}
                    @if(session('newsletter_success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="lastudioicon-check-1"></i> {{ session('newsletter_success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- Info Message --}}
                    @if(session('newsletter_info'))
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <i class="lastudioicon-i-information"></i> {{ session('newsletter_info') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- Error Message --}}
                    @if(session('newsletter_error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="lastudioicon-close"></i> {{ session('newsletter_error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- Validation Errors --}}
                    @if($errors->has('email'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="lastudioicon-close"></i> {{ $errors->first('email') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form class="newsletter-form" action="{{ route('newsletter.subscribe') }}" method="POST">
                        @csrf
                        <input class="form-control @error('email') is-invalid @enderror" 
                               type="email" 
                               name="email" 
                               id="email" 
                               placeholder="Enter your email address..." 
                               value="{{ old('email') }}"
                               required>
                        <button class="btn btn-submit" type="submit">Subscribe</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!--== End Newsletter Area -->


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
    
    // Hide add to cart if out of stock
    const addToCartSection = document.querySelector('.product-quick-view-modal .quick-product-action');
    if (addToCartSection) {
        if (stock > 0) {
            addToCartSection.style.display = 'block';
        } else {
            addToCartSection.style.display = 'none';
        }
    }
    
    // Hide wishlist and compare buttons
    const actionBottom = document.querySelector('.product-quick-view-modal .action-bottom');
    if (actionBottom) {
        actionBottom.style.display = 'none';
    }
    
    // Update "View Full Details" button link
    const viewDetailsBtn = document.querySelector('.product-quick-view-modal .btn-theme');
    if (viewDetailsBtn) {
        viewDetailsBtn.href = productUrl;
    }
    
    // Update all other product links
    const productLinks = document.querySelectorAll('.product-quick-view-modal a[href*="shop-single-product"]');
    productLinks.forEach(link => {
        if (!link.classList.contains('btn-close') && !link.classList.contains('btn-theme')) {
            link.href = productUrl;
        }
    });
    
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

/* Hide wishlist and compare in quick view */
.product-quick-view-modal .action-bottom {
    display: none !important;
}

/* Out of stock styling */
.product-quick-view-modal .text-danger {
    color: #dc3545;
    font-weight: 600;
}
</style>
@endpush