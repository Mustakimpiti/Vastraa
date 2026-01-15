@extends('layouts.app')

@section('title', $blog->meta_title ?? $blog->title . ' - Blog')

@section('content')
<!--== Start Page Title Area ==-->
<section class="page-title-area bg-img" data-bg-img="{{ asset('assets/img/photos/bg-page1.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-title-content">
                    <h2 class="title">Blog</h2>
                    <div class="bread-crumbs">
                        <a href="{{ route('home') }}">Home<span class="breadcrumb-sep">></span></a>
                        <a href="{{ route('blogs') }}">Blog<span class="breadcrumb-sep">></span></a>
                        <span class="active">Blog Details</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--== End Page Title Area ==-->

<!--== Start Blog Area Wrapper ==-->
<section class="blog-details-area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="blog-content-column">
                    <div class="blog-content-area no-sidebar">
                        <div class="post-details-content">
                            <div class="post-details-body">
                                <div class="content">
                                    @if($blog->featured_image)
                                    <div class="thumb">
                                        <img class="w-100" src="{{ asset($blog->featured_image) }}" alt="{{ $blog->title }}">
                                    </div>
                                    @endif

                                    <div class="category">
                                        <a href="{{ route('blogs') }}">{{ $blog->category ?? 'Saree Stories' }}</a>
                                    </div>

                                    <h4>{{ $blog->title }}</h4>

                                    <ul class="meta">
                                        <li class="author">By <a href="#">{{ $blog->author_name }}</a></li>
                                        <li> | </li>
                                        <li class="date">{{ $blog->formatted_date }}</li>
                                    </ul>

                                    @if($blog->excerpt)
                                    <div class="blockquote-area">
                                        <blockquote class="blockquote-style1">{{ $blog->excerpt }}</blockquote>
                                    </div>
                                    @endif

                                    <div class="blog-post-content">
                                        {!! $blog->content !!}
                                    </div>

                                    <div class="category-social-content">
                                        <div class="category-items">
                                            <span>Tags:</span>
                                            <a href="{{ route('blogs') }}">Saree,</a>
                                            <a href="{{ route('blogs') }}">Fashion,</a>
                                            <a href="{{ route('blogs') }}">Style</a>
                                        </div>
                                        <div class="social-items">
                                            <a class="one" href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('blog.show', $blog->slug)) }}" target="_blank" rel="noopener noreferrer">
                                                <i class="lastudioicon-b-facebook"></i>
                                            </a>
                                            <a class="two" href="https://twitter.com/intent/tweet?url={{ urlencode(route('blog.show', $blog->slug)) }}&text={{ urlencode($blog->title) }}" target="_blank" rel="noopener noreferrer">
                                                <i class="lastudioicon-b-twitter"></i>
                                            </a>
                                            <a class="three" href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(route('blog.show', $blog->slug)) }}" target="_blank" rel="noopener noreferrer">
                                                <i class="lastudioicon-b-linkedin"></i>
                                            </a>
                                            <a class="four" href="https://www.pinterest.com/pin/create/button/?url={{ urlencode(route('blog.show', $blog->slug)) }}&description={{ urlencode($blog->title) }}" target="_blank" rel="noopener noreferrer">
                                                <i class="lastudioicon-b-pinterest"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="comments-area">
                                    <h2>Leave a Reply</h2>
                                    <div class="comments-form-wrap">
                                        <div class="clearfix"></div>
                                        <form action="#" method="post">
                                            @csrf
                                            <div class="comments-form-content">
                                                <div class="row row-gutter-20">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <textarea class="form-control textarea" name="comment" rows="5" placeholder="Your Comment Here..." required=""></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <input class="form-control" type="text" name="name" placeholder="Name (required)" required="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <input class="form-control" type="email" name="email" placeholder="Email" required="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <input class="form-control" type="text" name="website" placeholder="Website">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <div class="comment-form-cookies">
                                                                <input id="comment-cookies" name="comment-cookies" type="checkbox" value="yes">
                                                                <label for="comment-cookies">Save my name, email, and website in this browser for the next time I comment.</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <button class="btn-theme btn btn-black" type="submit">Post Comment</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--== End Blog Area Wrapper ==-->

<!--== Start Blog Area Wrapper ==-->
@if($relatedBlogs->count() > 0)
<section class="blog-area blog-related-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12 m-auto">
                <div class="section-title text-center">
                    <h2 class="title">Related Posts</h2>
                </div>
            </div>
        </div>
        <div class="row post-items-style3">
            @foreach($relatedBlogs as $related)
            <div class="col-sm-6 col-md-4">
                <!--== Start Blog Post Item ==-->
                <div class="post-item {{ $loop->index > 0 ? 'mt-xs-30' : '' }} {{ $loop->index > 1 ? 'mt-sm-30' : '' }}">
                    <div class="thumb">
                        <a href="{{ route('blog.show', $related->slug) }}">
                            <img class="w-100" src="{{ $related->featured_image ? asset($related->featured_image) : asset('assets/img/blog/b1.jpg') }}" alt="{{ $related->title }}">
                        </a>
                    </div>
                    <div class="content">
                        <h4 class="title">
                            <a href="{{ route('blog.show', $related->slug) }}">{{ Str::limit($related->title, 50) }}</a>
                        </h4>
                    </div>
                </div>
                <!--== End Blog Post Item ==-->
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
<!--== End Blog Area Wrapper ==-->
@endsection