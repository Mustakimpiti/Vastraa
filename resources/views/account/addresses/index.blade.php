@extends('layouts.app')

@section('title', 'My Addresses - Saree Shop')

@section('content')
<!--== Start Page Title Area ==-->
<section class="page-title-area bg-img" data-bg-img="{{ asset('assets/img/photos/bg-page1.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-title-content">
                    <h2 class="title">My Addresses</h2>
                    <div class="bread-crumbs">
                        <a href="{{ route('home') }}">Home<span class="breadcrumb-sep">></span></a>
                        <a href="{{ route('account') }}">My Account<span class="breadcrumb-sep">></span></a>
                        <span class="active">Addresses</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--== End Page Title Area ==-->

<!--== Start Addresses Section ==-->
<section class="contact-area">
    <div class="container">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fa fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h3>Saved Addresses</h3>
                    <a href="{{ route('addresses.create') }}" class="btn btn-theme btn-black">
                        <i class="fa fa-plus me-2"></i>Add New Address
                    </a>
                </div>
            </div>
        </div>

        @if($addresses->count() > 0)
        <div class="row">
            @foreach($addresses as $address)
            <div class="col-md-6 mb-4">
                <div class="address-card {{ $address->is_default ? 'default-address' : '' }}">
                    @if($address->is_default)
                    <div class="default-badge">
                        <span class="badge bg-success">Default Address</span>
                    </div>
                    @endif
                    
                    <div class="address-content">
                        <h5>{{ $address->full_name }}</h5>
                        <p class="mb-2">{{ $address->street_address }}{{ $address->apartment ? ', ' . $address->apartment : '' }}</p>
                        <p class="mb-2">{{ $address->city }}, {{ $address->state }} {{ $address->zip }}</p>
                        <p class="mb-2">{{ $address->country }}</p>
                        <p class="mb-0"><strong>Phone:</strong> {{ $address->phone }}</p>
                    </div>

                    <div class="address-actions mt-3">
                        @if(!$address->is_default)
                        <form action="{{ route('addresses.set-default', $address) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-success">
                                <i class="fa fa-check me-1"></i>Set as Default
                            </button>
                        </form>
                        @endif
                        
                        <a href="{{ route('addresses.edit', $address) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fa fa-edit me-1"></i>Edit
                        </a>
                        
                        <form action="{{ route('addresses.destroy', $address) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this address?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="fa fa-trash me-1"></i>Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="row">
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <h5>No saved addresses yet</h5>
                    <p class="mb-3">Add an address to make checkout faster!</p>
                    <a href="{{ route('addresses.create') }}" class="btn btn-theme btn-black">
                        <i class="fa fa-plus me-2"></i>Add Your First Address
                    </a>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>
<!--== End Addresses Section ==-->

<style>
.address-card {
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    padding: 20px;
    position: relative;
    transition: all 0.3s ease;
    height: 100%;
}

.address-card:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.address-card.default-address {
    border-color: #10b981;
    background-color: #f0fdf4;
}

.default-badge {
    position: absolute;
    top: 10px;
    right: 10px;
}

.address-content h5 {
    color: #1f2937;
    margin-bottom: 12px;
    font-size: 18px;
    font-weight: 600;
}

.address-content p {
    color: #6b7280;
    font-size: 14px;
    line-height: 1.6;
}

.address-actions {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.address-actions .btn {
    font-size: 13px;
    padding: 6px 12px;
}
</style>
@endsection