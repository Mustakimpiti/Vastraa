@extends('layouts.app')

@section('title', 'Blog - Clothing Shop')

@push('styles')
<style>
.post-item {
    display: flex;
    flex-direction: column;
    height: 100%;
}

.post-item .thumb {
    width: 100%;
    height: 250px;
    overflow: hidden;
    position: relative;
}

.post-item .thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
}

.post-item .content {
    display: flex;
    flex-direction: column;
    flex-grow: 1;
}

.post-item .inner-content {
    flex-grow: 1;
    margin-bottom: 15px;
}

.post-item .inner-content p {
    margin-bottom: 0;
}

.post-item .btn-theme {
    margin-top: auto;
}
</style>
@endpush

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
                        <span class="active">Blog</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--== End Page Title Area ==-->

<!--== Start Blog Area Wrapper ==-->
<section class="blog-area blog-grid-area">
    <div class="container">
        <div class="row">
            @forelse($blogs as $blog)
            <!--== Start Blog Post Item ==-->
            <div class="col-lg-4 col-md-6 col-12 mb-4">
                <div class="post-item">
                    <div class="thumb">
                        <a href="{{ route('blog.show', $blog->slug) }}">
                            <img src="{{ $blog->featured_image ? asset($blog->featured_image) : asset('assets/img/blog/1.jpg') }}" 
                                 alt="{{ $blog->title }}">
                        </a>
                    </div>
                    <div class="content">
                        <div class="meta">
                            <a href="{{ route('blogs') }}">{{ $blog->category ?? 'Saree Stories' }}</a>
                        </div>
                        <div class="inner-content">
                            <h4 class="title">
                                <a href="{{ route('blog.show', $blog->slug) }}">{{ $blog->title }}</a>
                            </h4>
                            <p>{{ Str::limit($blog->excerpt, 150) }} […]</p>
                        </div>
                        <a href="{{ route('blog.show', $blog->slug) }}" class="btn-theme btn-black">Read more</a>
                    </div>
                </div>
            </div>
            <!--== End Blog Post Item ==-->
            @empty
            <div class="col-12 text-center py-100">
                <h4>No blog posts available yet.</h4>
                <p>Check back soon for exciting stories and style guides!</p>
            </div>
            @endforelse
        </div>

        @if($blogs->hasPages())
        <div class="row">
            <div class="col-12">
                <div class="pagination-area">
                    <nav>
                        <ul class="page-numbers">
                            @if ($blogs->onFirstPage())
                                <li><span class="page-number disabled">«</span></li>
                            @else
                                <li><a class="page-number" href="{{ $blogs->previousPageUrl() }}">«</a></li>
                            @endif

                            @foreach ($blogs->getUrlRange(1, $blogs->lastPage()) as $page => $url)
                                @if ($page == $blogs->currentPage())
                                    <li><a class="page-number active" href="#">{{ $page }}</a></li>
                                @else
                                    <li><a class="page-number" href="{{ $url }}">{{ $page }}</a></li>
                                @endif
                            @endforeach

                            @if ($blogs->hasMorePages())
                                <li>
                                    <a class="page-number next" href="{{ $blogs->nextPageUrl() }}">
                                        <i class="icofont-long-arrow-right"></i>
                                    </a>
                                </li>
                            @else
                                <li><span class="page-number disabled">»</span></li>
                            @endif
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>
<!--== End Blog Area Wrapper ==-->
@endsection