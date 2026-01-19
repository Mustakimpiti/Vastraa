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
<section class="category-area category-trending-area">
   <div class="container">
      <div class="row">
         <div class="col-md-8 m-auto">
            <div class="section-title text-center" data-aos="fade-up" data-aos-duration="1000">
               <h2 class="title">Trending Now</h2>
            </div>
         </div>
      </div>
   </div>
   <div class="saree-video">
      @forelse($trendingVideos as $video)
      <a href="{{ route('videos.viewer') }}#video-{{ $loop->index }}" class="video-item">
         <video playsinline="true" autoplay="autoplay" loop="loop" muted="muted" preload="metadata">
            <source src="{{ asset($video->video_path) }}" type="video/mp4">
            <img src="{{ asset('assets/img/shop/1.jpg') }}" alt="{{ $video->title }}">
         </video>
      </a>
      @empty
      <!-- Fallback if no videos -->
      <a href="#" class="video-item">
         <video playsinline="true" autoplay="autoplay" loop="loop" muted="muted" preload="metadata">
            <source src="{{ asset('assets/img/Video-720.mp4') }}" type="video/mp4">
            <img src="{{ asset('assets/img/shop/1.jpg') }}" alt="Video">
         </video>
      </a>
      <a href="#" class="video-item">
         <video playsinline="true" autoplay="autoplay" loop="loop" muted="muted" preload="metadata">
            <source src="{{ asset('assets/img/Video-653.mp4') }}" type="video/mp4">
            <img src="{{ asset('assets/img/shop/1.jpg') }}" alt="Video">
         </video>
      </a>
      <a href="#" class="video-item">
         <video playsinline="true" autoplay="autoplay" loop="loop" muted="muted" preload="metadata">
            <source src="{{ asset('assets/img/Video-720.mp4') }}" type="video/mp4">
            <img src="{{ asset('assets/img/shop/1.jpg') }}" alt="Video">
         </video>
      </a>
      @endforelse
   </div>
</section>
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
<!--== Start Testimonials Area Wrapper ==-->
<section class="testimonial-area testimonial-about-area">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-lg-6 m-auto">
                <div class="section-title text-center" data-aos="fade-up" data-aos-duration="1000">
                    <h2 class="title">What Our Customers Say</h2>
                    <h5 class="subtitle">TESTIMONIALS</h5>
                </div>
            </div>
        </div>
        <div class="row testimonial-items" data-aos="fade-up" data-aos-duration="1200">
            <div class="col-12">
                <div class="swiper-container testimonial-slider-container">
                    <div class="swiper-wrapper">
                        @forelse($testimonials as $testimonial)
                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <div class="testimonial-image">
                                    @if($testimonial->customer_image)
                                        <img src="{{ asset($testimonial->customer_image) }}" alt="{{ $testimonial->customer_name }}">
                                    @else
                                        <img src="{{ asset('assets/img/icons/user-default.png') }}" alt="{{ $testimonial->customer_name }}">
                                    @endif
                                </div>
                                <div class="testimonial-content">
                                    <div class="testimonial-text">
                                        <div class="rating">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $testimonial->rating)
                                                <span class="lastudioicon-star-rate-1"></span>
                                                @else
                                                <span class="lastudioicon-star-rate-2"></span>
                                                @endif
                                            @endfor
                                        </div>
                                        <p>"{{ $testimonial->testimonial }}"</p>
                                    </div>
                                    <div class="testimonial-author">
                                        <h5>{{ $testimonial->customer_name }}</h5>
                                        @if($testimonial->customer_location)
                                        <span>{{ $testimonial->customer_location }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <div class="testimonial-image">
                                    <img src="{{ asset('assets/img/icons/user-default.png') }}" alt="Customer">
                                </div>
                                <div class="testimonial-content">
                                    <div class="testimonial-text">
                                        <div class="rating">
                                            <span class="lastudioicon-star-rate-1"></span>
                                            <span class="lastudioicon-star-rate-1"></span>
                                            <span class="lastudioicon-star-rate-1"></span>
                                            <span class="lastudioicon-star-rate-1"></span>
                                            <span class="lastudioicon-star-rate-1"></span>
                                        </div>
                                        <p>"No testimonials yet. Be the first to share your experience!"</p>
                                    </div>
                                    <div class="testimonial-author">
                                        <h5>Our Valued Customer</h5>
                                        <span>Location</span>
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
<!--== End Testimonials Area Wrapper ==-->

<style>
/* Testimonials Area Styles */
.testimonial-area {
    padding: 80px 0;
    background: #f9f9f9;
}

.testimonial-slider-container .swiper-slide {
    height: auto;
    display: flex;
}

.testimonial-item {
    background: #fff;
    border-radius: 10px;
    padding: 25px;
    margin: 10px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
    height: 100%;
    min-height: 320px;
    width: 100%;
}

.testimonial-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
}

/* Fixed Image Section */
.testimonial-image {
    flex-shrink: 0;
    width: 90px;
    height: 90px;
    border-radius: 50%;
    overflow: hidden;
    border: 4px solid #d4af37;
    margin: 0 auto 15px;
    align-self: center;
}

.testimonial-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Content Section */
.testimonial-content {
    flex: 1;
    display: flex;
    flex-direction: column;
    text-align: center;
}

/* Fixed Rating Section */
.testimonial-text {
    margin-bottom: auto;
}

.testimonial-item .rating {
    display: flex;
    gap: 5px;
    font-size: 16px;
    color: #d4af37;
    margin-bottom: 15px;
    justify-content: center;
    height: 20px;
}

/* Flexible Text Content */
.testimonial-text p {
    font-size: 14px;
    line-height: 1.6;
    color: #666;
    font-style: italic;
    margin: 0 0 15px 0;
    display: -webkit-box;
    -webkit-line-clamp: 5;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    min-height: 110px;
}

/* Fixed Author Section - Always at Bottom */
.testimonial-author {
    margin-top: auto;
    padding-top: 12px;
    border-top: 1px solid #f0f0f0;
}

.testimonial-author h5 {
    font-size: 17px;
    font-weight: 600;
    margin: 0 0 5px 0;
    color: #333;
    height: 22px;
    line-height: 22px;
}

.testimonial-author span {
    font-size: 14px;
    color: #999;
    display: block;
    height: 20px;
    line-height: 20px;
}

/* Swiper Pagination */
.testimonial-slider-container .swiper-pagination {
    position: relative;
    margin-top: 30px;
}

.testimonial-slider-container .swiper-pagination-bullet {
    width: 12px;
    height: 12px;
    background: #ddd;
    opacity: 1;
    transition: all 0.3s ease;
}

.testimonial-slider-container .swiper-pagination-bullet-active {
    background: #d4af37;
    width: 30px;
    border-radius: 6px;
}

/* Responsive */
@media (max-width: 767px) {
    .testimonial-area {
        padding: 60px 0;
    }
    
    .testimonial-item {
        padding: 20px 18px;
        min-height: 300px;
    }
    
    .testimonial-image {
        width: 80px;
        height: 80px;
        margin-bottom: 15px;
    }
    
    .testimonial-text p {
        font-size: 13px;
        min-height: 100px;
        -webkit-line-clamp: 5;
    }
    
    .testimonial-author h5 {
        font-size: 16px;
    }
    
    .testimonial-author span {
        font-size: 13px;
    }
}

@media (min-width: 768px) and (max-width: 991px) {
    .testimonial-item {
        min-height: 310px;
    }
    
    .testimonial-image {
        width: 85px;
        height: 85px;
    }
    
    .testimonial-text p {
        font-size: 13px;
        min-height: 105px;
    }
}

@media (min-width: 992px) {
    .testimonial-slider-container .swiper-wrapper {
        align-items: stretch;
    }
}
</style>

<script>
// Initialize Testimonial Slider
document.addEventListener('DOMContentLoaded', function() {
    var testimonialSlider = new Swiper('.testimonial-slider-container', {
        slidesPerView: 1,
        spaceBetween: 30,
        loop: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.testimonial-slider-container .swiper-pagination',
            clickable: true,
        },
        breakpoints: {
            992: {
                slidesPerView: 2,
            }
        }
    });
});
</script>
<!--== Start Newsletter Area ==-->
<section class="newsletter-area bg-overlay-black2-6 bg-parallax" data-speed="1.136" data-bg-img="assets/img/photos/bg-d4.jpg">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 m-auto">
                <div class="newsletter-content content-style3" data-aos="fade-up" data-aos-duration="1000">
                    <h1 class="title">Stay in the loop</h1>
                    <p>Sign up for our newsletter to be updated with the latest products and news.</p>

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

<!--== Newsletter Popup Modal ==-->
<div class="newsletter-popup-modal" id="newsletterModal">
    <div class="newsletter-popup-overlay" onclick="closeNewsletterModal()"></div>
    <div class="newsletter-popup-content">
        <button type="button" class="newsletter-close-btn" onclick="closeNewsletterModal()">
            <i class="lastudioicon-e-remove"></i>
        </button>
        
        <div class="newsletter-popup-body">
            <div class="newsletter-icon-wrapper" id="modalIconWrapper">
                <!-- Icon will be added dynamically -->
            </div>
            
            <h2 class="newsletter-popup-title" id="modalTitle">Thank You!</h2>
            <p class="newsletter-popup-message" id="modalMessage">Your message will appear here</p>
            
            <button type="button" class="btn-theme newsletter-popup-btn" onclick="closeNewsletterModal()">
                Got it
            </button>
        </div>
    </div>
</div>
<!--== End Newsletter Popup Modal ==-->

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
    
    // Hide the entire "Add to Cart" section (including quantity selector and button)
    const addToCartSection = document.querySelector('.product-quick-view-modal .quick-product-action');
    if (addToCartSection) {
        addToCartSection.style.display = 'none';
    }
    
    // Also hide any other add to cart forms
    const addToCartForms = document.querySelectorAll('.product-quick-view-modal form[action*="cart"]');
    addToCartForms.forEach(form => {
        form.style.display = 'none';
    });
    
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
}    // Update product image
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
    
    // Update add to cart form with product ID and hide quantity selector
    const addToCartForm = document.querySelector('.product-quick-view-modal form[action*="cart"]');
    if (addToCartForm) {
        const sareeIdInput = addToCartForm.querySelector('input[name="saree_id"]');
        if (sareeIdInput) {
            sareeIdInput.value = id;
        }
        
        // Hide quantity selector in quick view
        const quantityWrapper = addToCartForm.querySelector('.product-quantity-wrapper, .quantity-wrapper, .product-quantity');
        if (quantityWrapper) {
            quantityWrapper.style.display = 'none';
        }
        
        // Set quantity to 1 by default
        const quantityInput = addToCartForm.querySelector('input[name="quantity"]');
        if (quantityInput) {
            quantityInput.value = 1;
        }
    }
    
    // Hide add to cart if out of stock
    const addToCartSection = document.querySelector('.product-quick-view-modal .quick-product-action');
    if (addToCartSection) {
        if (stock > 0) {
            addToCartSection.style.display = 'flex';
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

// Newsletter Modal Functions
function showNewsletterModal(type, title, message) {
    const modal = document.getElementById('newsletterModal');
    const modalTitle = document.getElementById('modalTitle');
    const modalMessage = document.getElementById('modalMessage');
    const iconWrapper = document.getElementById('modalIconWrapper');
    
    // Clear previous icon
    iconWrapper.innerHTML = '';
    
    // Set icon based on type
    let iconHtml = '';
    if (type === 'success') {
        iconHtml = '<div class="newsletter-icon newsletter-icon-success"><svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg></div>';
    } else if (type === 'error') {
        iconHtml = '<div class="newsletter-icon newsletter-icon-error"><svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></div>';
    } else if (type === 'info') {
        iconHtml = '<div class="newsletter-icon newsletter-icon-info"><svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg></div>';
    }
    
    iconWrapper.innerHTML = iconHtml;
    modalTitle.textContent = title;
    modalMessage.textContent = message;
    
    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeNewsletterModal() {
    const modal = document.getElementById('newsletterModal');
    modal.classList.remove('active');
    document.body.style.overflow = '';
}

// Show modal if there are session messages
document.addEventListener('DOMContentLoaded', function() {
    @if(session('newsletter_success'))
        showNewsletterModal('success', 'Success!', '{{ session('newsletter_success') }}');
    @elseif(session('newsletter_info'))
        showNewsletterModal('info', 'Already Subscribed', '{{ session('newsletter_info') }}');
    @elseif(session('newsletter_error'))
        showNewsletterModal('error', 'Oops!', '{{ session('newsletter_error') }}');
    @elseif($errors->has('email'))
        showNewsletterModal('error', 'Invalid Email', '{{ $errors->first('email') }}');
    @endif
});

// Close modal on ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeNewsletterModal();
    }
});

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

/* Newsletter Popup Modal Styles */
.newsletter-popup-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}

.newsletter-popup-modal.active {
    opacity: 1;
    visibility: visible;
}

.newsletter-popup-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    backdrop-filter: blur(5px);
}

.newsletter-popup-content {
    position: relative;
    background: #fff;
    border-radius: 20px;
    max-width: 500px;
    width: 90%;
    padding: 50px 40px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    transform: scale(0.9);
    transition: transform 0.3s ease;
    z-index: 10;
}

.newsletter-popup-modal.active .newsletter-popup-content {
    transform: scale(1);
}

.newsletter-close-btn {
    position: absolute;
    top: 20px;
    right: 20px;
    width: 40px;
    height: 40px;
    border: none;
    background: #f5f5f5;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 20px;
    color: #333;
}

.newsletter-close-btn:hover {
    background: #e0e0e0;
    transform: rotate(90deg);
}

.newsletter-popup-body {
    text-align: center;
}

.newsletter-icon-wrapper {
    margin-bottom: 25px;
}

.newsletter-icon {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 40px;
    animation: scaleIn 0.5s ease;
}

.newsletter-icon-success {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: #fff;
    box-shadow: 0 10px 30px rgba(16, 185, 129, 0.3);
}

.newsletter-icon-error {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: #fff;
    box-shadow: 0 10px 30px rgba(239, 68, 68, 0.3);
}

.newsletter-icon-info {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: #fff;
    box-shadow: 0 10px 30px rgba(59, 130, 246, 0.3);
}

.newsletter-popup-title {
    font-size: 28px;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 15px;
    line-height: 1.3;
}

.newsletter-popup-message {
    font-size: 16px;
    color: #6b7280;
    margin-bottom: 30px;
    line-height: 1.6;
}

.newsletter-popup-btn {
    display: inline-block;
    padding: 14px 40px;
    font-size: 16px;
    font-weight: 600;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    min-width: 150px;
}

.newsletter-popup-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
}

@keyframes scaleIn {
    0% {
        transform: scale(0);
        opacity: 0;
    }
    50% {
        transform: scale(1.1);
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}

/* Responsive */
@media (max-width: 576px) {
    .newsletter-popup-content {
        padding: 40px 30px;
    }
    
    .newsletter-popup-title {
        font-size: 24px;
    }
    
    .newsletter-popup-message {
        font-size: 14px;
    }
    
    .newsletter-icon {
        width: 70px;
        height: 70px;
        font-size: 35px;
    }
}
/* Hide Add to Cart in Quick View */
.product-quick-view-modal .quick-product-action {
    display: none !important;
}

.product-quick-view-modal form[action*="cart"] {
    display: none !important;
}

.product-quick-view-modal .product-quantity-wrapper,
.product-quick-view-modal .quantity-wrapper,
.product-quick-view-modal .product-quantity {
    display: none !important;
}

/* Hide wishlist and compare in quick view */
.product-quick-view-modal .action-bottom {
    display: none !important;
}

/* Make sure "View Full Details" button is prominent */
.product-quick-view-modal .btn-theme {
    margin-top: 20px;
    display: inline-block;
}
</style>
@endpush