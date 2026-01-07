{{-- File: resources/views/pages/shop-collections.blade.php --}}
@extends('layouts.app')

@section('title', 'Saree Collections - Clothing Shop')

@push('styles')
<style>
/* Collection Cards Styling */
.collection-card {
    position: relative;
    overflow: hidden;
    border-radius: 8px;
    margin-bottom: 30px;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.collection-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}

.collection-image-wrapper {
    position: relative;
    overflow: hidden;
    padding-bottom: 125%; /* 4:5 aspect ratio */
    background: #f8f9fa;
}

.collection-image-wrapper img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.collection-card:hover .collection-image-wrapper img {
    transform: scale(1.1);
}

.collection-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(to bottom, rgba(0,0,0,0.1) 0%, rgba(0,0,0,0.7) 100%);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.collection-card:hover .collection-overlay {
    opacity: 1;
}

.collection-content {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 25px;
    color: #fff;
    z-index: 2;
    transform: translateY(10px);
    transition: transform 0.3s ease;
}

.collection-card:hover .collection-content {
    transform: translateY(0);
}

.collection-title {
    font-size: 24px;
    font-weight: 700;
    margin-bottom: 8px;
    color: #fff;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
}

.collection-count {
    font-size: 14px;
    color: #fff;
    opacity: 0.9;
    margin-bottom: 15px;
}

.collection-description {
    font-size: 14px;
    line-height: 1.6;
    color: #fff;
    margin-bottom: 15px;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.collection-card:hover .collection-description {
    opacity: 1;
}

.btn-view-collection {
    display: inline-block;
    background: #fff;
    color: #000;
    padding: 10px 25px;
    border-radius: 25px;
    font-size: 13px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: all 0.3s ease;
    opacity: 0;
    transform: translateY(10px);
}

.collection-card:hover .btn-view-collection {
    opacity: 1;
    transform: translateY(0);
}

.btn-view-collection:hover {
    background: #000;
    color: #fff;
}

.collection-badge {
    position: absolute;
    top: 15px;
    right: 15px;
    background: linear-gradient(135deg, #ff4757 0%, #ff6b81 100%);
    color: #fff;
    padding: 6px 15px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
    z-index: 3;
    box-shadow: 0 4px 15px rgba(255, 71, 87, 0.4);
}

/* Page Header */
.collections-header {
    text-align: center;
    margin-bottom: 50px;
}

.collections-header h2 {
    font-size: 36px;
    font-weight: 700;
    margin-bottom: 15px;
}

.collections-header p {
    font-size: 16px;
    color: #666;
    max-width: 600px;
    margin: 0 auto;
}
</style>
@endpush

@section('content')
<section class="page-title-area bg-img" data-bg-img="{{ asset('assets/img/photos/bg-page1.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-title-content">
                    <h2 class="title">Saree Collections</h2>
                    <div class="bread-crumbs">
                        <a href="{{ route('home') }}">Home<span class="breadcrumb-sep">></span></a>
                        <span class="active">Collections</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="product-area" style="padding: 80px 0;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="collections-header">
                    <h2>Explore Our Saree Collections</h2>
                    <p>Discover our exquisite range of sarees, carefully curated to bring you the finest selection of traditional and contemporary designs.</p>
                </div>
            </div>
        </div>

        <div class="row">
            @forelse($collections as $collection)
            <div class="col-md-6 col-lg-4">
                <div class="collection-card">
                    <div class="collection-image-wrapper">
                        @php
                            $imageUrl = $collection->image 
                                ? asset($collection->image) 
                                : asset('assets/img/shop/default-collection.jpg');
                        @endphp
                        <img src="{{ $imageUrl }}" alt="{{ $collection->name }}">
                        <div class="collection-overlay"></div>
                    </div>
                    
                    @if($collection->launch_date && $collection->launch_date->isFuture())
                        <span class="collection-badge">Coming Soon</span>
                    @elseif($collection->launch_date && $collection->launch_date->isToday())
                        <span class="collection-badge">New Launch</span>
                    @endif

                    <div class="collection-content">
                        <h3 class="collection-title">{{ $collection->name }}</h3>
                        <p class="collection-count">{{ $collection->active_sarees_count }} {{ Str::plural('Saree', $collection->active_sarees_count) }}</p>
                        
                        @if($collection->description)
                        <p class="collection-description">{{ Str::limit($collection->description, 100) }}</p>
                        @endif
                        
                        <a href="{{ route('collections.show', $collection->slug) }}" class="btn-view-collection">
                            View Collection
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-lg-12 text-center py-5">
                <h3>No collections available</h3>
                <p>Check back soon for our latest saree collections!</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!--== Start Featured Area ==-->
<section class="featured-area featured-style3-area">
    <div class="container">
        <div class="row featured-style3">
            <div class="col-sm-6 col-md-4">
                <div class="featured-item">
                    <div class="content">
                        <span class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="76" height="46" fill="none" viewBox="0 0 76 46">
                                <path fill="currentColor" d="M74.757 45.702H1.243a1.08 1.08 0 0 1-1.08-1.08V33.593a1.081 1.081 0 0 1 .864-1.06 9.73 9.73 0 0 0 0-19.07 1.081 1.081 0 0 1-.865-1.059V1.378A1.081 1.081 0 0 1 1.243.297h73.514a1.08 1.08 0 0 1 1.08 1.081v11.027a1.082 1.082 0 0 1-.864 1.06 9.73 9.73 0 0 0 0 19.07 1.081 1.081 0 0 1 .865 1.06V44.62a1.08 1.08 0 0 1-1.081 1.081zM2.324 43.54h71.352v-9.097a11.892 11.892 0 0 1 0-22.887V2.46H2.324v9.097a11.892 11.892 0 0 1 0 22.887v9.097z"></path>
                                <path fill="currentColor" d="M54.216 6.39a1.081 1.081 0 0 1-1.08-1.081V1.378a1.081 1.081 0 0 1 2.161 0v3.93a1.081 1.081 0 0 1-1.08 1.082zm0 9.828a1.08 1.08 0 0 1-1.08-1.08v-3.932a1.081 1.081 0 0 1 2.161 0v3.931a1.081 1.081 0 0 1-1.08 1.081zm0 9.828a1.08 1.08 0 0 1-1.08-1.081v-3.93a1.081 1.081 0 0 1 2.161 0v3.931a1.081 1.081 0 0 1-1.08 1.08zm0 9.828a1.08 1.08 0 0 1-1.08-1.08v-3.931a1.082 1.082 0 0 1 2.161 0v3.93a1.081 1.081 0 0 1-1.08 1.081zm0 9.828a1.08 1.08 0 0 1-1.08-1.08V40.69a1.082 1.082 0 0 1 2.161 0v3.931a1.081 1.081 0 0 1-1.08 1.081zm-33.59-11.305a1.081 1.081 0 0 1-.764-1.846l20.034-20.045a1.082 1.082 0 1 1 1.529 1.529L21.39 34.08a1.082 1.082 0 0 1-.764.316zm16.704.516a4.993 4.993 0 1 1 4.994-4.994 5 5 0 0 1-4.993 4.994zm0-7.826a2.832 2.832 0 1 0 .001 5.663 2.832 2.832 0 0 0 0-5.663zm-13.796-6.079a4.994 4.994 0 1 1 4.994-4.995 5 5 0 0 1-4.994 4.995zm0-7.826a2.832 2.832 0 1 0 0 5.663 2.832 2.832 0 0 0 0-5.663z"></path>
                            </svg>
                        </span>
                        <div class="inner-content">
                            <h4 class="title">SPECIAL OFFERS</h4>
                            <p>Exclusive discounts on select saree collections.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4">
                <div class="featured-item mt-xs-30">
                    <div class="content">
                        <span class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="76" height="72" fill="none" viewBox="0 0 76 72">
                                <path fill="currentColor" d="M64.733 71.123H11.267a4.432 4.432 0 0 1-4.422-4.42V31.614a1.081 1.081 0 0 1 1.081-1.08h60.147a1.081 1.081 0 0 1 1.082 1.08v35.089a4.432 4.432 0 0 1-4.422 4.42zM9.008 32.695v34.008a2.263 2.263 0 0 0 2.26 2.26h53.465a2.262 2.262 0 0 0 2.26-2.26V32.695H9.007z"></path>
                                <path fill="currentColor" d="M73.085 32.695H2.915a2.755 2.755 0 0 1-2.753-2.749v-8.357a2.755 2.755 0 0 1 2.753-2.751h70.17a2.755 2.755 0 0 1 2.753 2.751v8.357a2.755 2.755 0 0 1-2.753 2.75zM2.915 21a.59.59 0 0 0-.59.59v8.356a.59.59 0 0 0 .59.59h70.17a.59.59 0 0 0 .59-.59v-8.357a.59.59 0 0 0-.59-.589H2.915z"></path>
                                <path fill="currentColor" d="M40.23 21a1.081 1.081 0 0 1-1.032-1.404c1.336-4.276 3.732-10.054 7.554-13.333A7.946 7.946 0 0 1 57.08 18.34a17.38 17.38 0 0 1-4.117 2.558 1.082 1.082 0 0 1-1.267-1.718c.102-.104.224-.186.36-.242a15.29 15.29 0 0 0 3.614-2.235 5.782 5.782 0 1 0-7.507-8.796C44.55 11 42.29 16.963 41.265 20.242A1.081 1.081 0 0 1 40.23 21z"></path>
                                <path fill="currentColor" d="M40.23 21a1.08 1.08 0 0 1-1.031-.757c-1.281-4.094-4.108-11.54-8.636-15.42a7.433 7.433 0 0 0-9.66 11.3 19.242 19.242 0 0 0 4.55 2.816 1.08 1.08 0 1 1-.908 1.962 21.321 21.321 0 0 1-5.052-3.136A9.597 9.597 0 0 1 31.968 3.178c4.695 4.02 7.645 11.147 9.297 16.419A1.081 1.081 0 0 1 40.23 21zm3.932 50.123H31.838a1.081 1.081 0 0 1-1.081-1.08v-38.43a1.081 1.081 0 0 1 1.08-1.08h12.325a1.081 1.081 0 0 1 1.081 1.08v38.428a1.081 1.081 0 0 1-1.08 1.081zM32.92 68.961h10.16V32.695H32.92v36.266z"></path>
                            </svg>
                        </span>
                        <div class="inner-content">
                            <h4 class="title">AUTHENTIC DESIGNS</h4>
                            <p>Traditional and contemporary saree designs.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4">
                <div class="featured-item mt-sm-30">
                    <div class="content">
                        <span class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="76" height="74" fill="none" viewBox="0 0 76 74">
                                <path fill="currentColor" d="M74.757 73.649H1.243a1.08 1.08 0 0 1-1.08-1.081V20.4a1.081 1.081 0 0 1 1.08-1.081h73.514a1.08 1.08 0 0 1 1.08 1.081v52.168a1.08 1.08 0 0 1-1.08 1.08zM2.324 71.487h71.352V21.48H2.324v50.006z"></path>
                                <path fill="currentColor" d="M74.757 21.481H1.243a1.08 1.08 0 0 1-.865-1.73L14.607.785a1.081 1.081 0 0 1 .864-.432H60.53a1.081 1.081 0 0 1 .865.432l14.228 18.968a1.081 1.081 0 0 1-.865 1.73zM3.405 19.32h69.19L59.988 2.514H16.012L3.405 19.319z"></path>
                                <path fill="currentColor" d="M47.19 21.481H28.81a1.082 1.082 0 0 1-1.059-1.297l3.784-18.968a1.08 1.08 0 0 1 1.06-.864h10.81a1.08 1.08 0 0 1 1.06.864l3.784 18.971a1.08 1.08 0 0 1-1.06 1.297v-.003zM30.128 19.32H45.87L42.52 2.514h-9.038L30.13 19.319z"></path>
                                <path fill="currentColor" d="M47.19 41.848a1.08 1.08 0 0 1-.685-.245L38 34.653l-8.505 6.95a1.08 1.08 0 0 1-1.765-.836V20.4a1.08 1.08 0 0 1 1.08-1.081h18.38a1.08 1.08 0 0 1 1.08 1.081v20.367a1.08 1.08 0 0 1-1.08 1.08zM38 32.176c.25 0 .491.087.684.245l7.424 6.066V21.48H29.892v17.006l7.424-6.067a1.08 1.08 0 0 1 .684-.244z"></path>
                            </svg>
                        </span>
                        <div class="inner-content">
                            <h4 class="title">NATIONWIDE DELIVERY</h4>
                            <p>Fast and secure delivery across India.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--== End Featured Area ==-->
@endsection