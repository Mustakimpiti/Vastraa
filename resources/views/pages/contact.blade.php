@extends('layouts.app')

@section('title', 'Contact Us - Artfauj')

@push('styles')
<style>
    /* Force success message to be visible */
    .success-message-wrapper {
        position: relative;
        z-index: 9999;
        margin-top: 30px;
        margin-bottom: 30px;
    }
    
    .success-alert {
        background: #d4edda !important;
        border: 3px solid #28a745 !important;
        border-radius: 10px !important;
        padding: 25px !important;
        box-shadow: 0 4px 15px rgba(40,167,69,0.3) !important;
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
        animation: slideDown 0.5s ease-out;
    }
    
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .success-icon {
        font-size: 50px;
        color: #28a745;
        animation: bounceIn 0.6s ease-out;
    }
    
    @keyframes bounceIn {
        0% { transform: scale(0); }
        50% { transform: scale(1.2); }
        100% { transform: scale(1); }
    }
    
    #submit-btn:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }
    
    html {
        scroll-behavior: smooth;
    }
</style>
@endpush

@section('content')
<!--== Start Page Title Area ==-->
<section class="page-title-area bg-img" data-bg-img="{{ asset('assets/img/photos/bg-page3.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-title-content">
                    <h2 class="title">Contact Us</h2>
                    <div class="bread-crumbs">
                        <a href="{{ url('/') }}">Home<span class="breadcrumb-sep">></span></a>
                        <span class="active">Contact Us</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--== End Page Title Area ==-->

<!--== Start Contact Area ==-->
<section class="contact-area">
    <div class="container">
        {{-- Success Message - GUARANTEED TO SHOW --}}
        @if(request()->get('submitted') === 'success')
        <div class="success-message-wrapper">
            <div class="row">
                <div class="col-12">
                    <div class="alert success-alert alert-dismissible fade show" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" 
                                style="position: absolute; right: 20px; top: 20px;"></button>
                        <div style="display: flex; align-items: center; gap: 20px;">
                            <div class="success-icon">
                                ✅
                            </div>
                            <div>
                                <h4 style="color: #155724; margin: 0 0 8px 0; font-weight: bold; font-size: 22px;">
                                    Message Sent Successfully!
                                </h4>
                                <p style="color: #155724; margin: 0; font-size: 16px; line-height: 1.5;">
                                    Thank you for contacting us, <strong>{{ request()->get('name', 'valued customer') }}</strong>!<br>
                                    We have received your message and will respond within 24-48 hours.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- Session Success Message (Backup) --}}
        @if(session('success'))
        <div class="success-message-wrapper">
            <div class="row">
                <div class="col-12">
                    <div class="alert success-alert alert-dismissible fade show" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" 
                                style="position: absolute; right: 20px; top: 20px;"></button>
                        <div style="display: flex; align-items: center; gap: 20px;">
                            <div class="success-icon">✅</div>
                            <div>
                                <h4 style="color: #155724; margin: 0 0 8px 0; font-weight: bold; font-size: 22px;">
                                    Success!
                                </h4>
                                <p style="color: #155724; margin: 0; font-size: 16px;">
                                    {{ session('success') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- Error Message --}}
        @if(session('error'))
        <div class="row">
            <div class="col-12">
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-bottom: 30px;">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <strong>Error!</strong> {{ session('error') }}
                </div>
            </div>
        </div>
        @endif

        {{-- Validation Errors --}}
        @if($errors->any())
        <div class="row">
            <div class="col-12">
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-bottom: 30px;">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <h5 style="margin-bottom: 10px;"><strong>Please fix the following errors:</strong></h5>
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif

        <div class="row">
            <div class="col-lg-7">
                <div class="contact-form">
                    <form class="contact-form-wrapper form-style" id="contact-form" action="{{ route('contact.submit') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="section-title">
                                    <h2 class="title">Contact us for any questions</h2>
                                    <p class="subtitle">Every drape whispers elegance</p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input class="form-control @error('con_name') is-invalid @enderror" 
                                           type="text" 
                                           name="con_name" 
                                           id="con_name"
                                           placeholder="Name*" 
                                           value="{{ request()->get('submitted') === 'success' ? '' : old('con_name') }}" 
                                           required>
                                    @error('con_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input class="form-control @error('con_email') is-invalid @enderror" 
                                           type="email" 
                                           name="con_email" 
                                           id="con_email"
                                           placeholder="Email*" 
                                           value="{{ request()->get('submitted') === 'success' ? '' : old('con_email') }}" 
                                           required>
                                    @error('con_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input class="form-control @error('con_phone') is-invalid @enderror" 
                                           type="text" 
                                           name="con_phone" 
                                           id="con_phone"
                                           placeholder="Phone Number"
                                           value="{{ request()->get('submitted') === 'success' ? '' : old('con_phone') }}">
                                    @error('con_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-0">
                                    <textarea class="form-control textarea @error('con_message') is-invalid @enderror" 
                                              name="con_message" 
                                              id="con_message"
                                              placeholder="How can we help?" 
                                              required>{{ request()->get('submitted') === 'success' ? '' : old('con_message') }}</textarea>
                                    @error('con_message')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-0">
                                    <button class="btn btn-theme btn-black" type="submit" id="submit-btn">
                                        Send Message
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="contact-info-wrapper">
                    <div class="section-title">
                        <h2 class="title">Get in Touch</h2>
                    </div>
                    <div class="contact-info-content">
                        <div class="align-top">
                            <div class="contact-info-item">
                                <div class="icon">
                                    <i class="lastudioicon lastudioicon-pin-3-2"></i>
                                </div>
                                <div class="content">
                                    <h4>Artfauj Registered Office</h4>
                                    <p>
                                        {{ $contactSettings->address_line1 }}<br>
                                        @if($contactSettings->address_line2)
                                            {{ $contactSettings->address_line2 }}<br>
                                        @endif
                                        @if($contactSettings->address_line3)
                                            {{ $contactSettings->address_line3 }}<br>
                                        @endif
                                        {{ $contactSettings->city }} - {{ $contactSettings->zip }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="align-bottom">
                            <div class="contact-info-item">
                                <div class="icon">
                                    <span><i class="lastudioicon lastudioicon-phone-call-2"></i></span>
                                </div>
                                <div class="content">
                                    <p>{{ $contactSettings->phone1 }}</p>
                                    @if($contactSettings->phone2)
                                        <p>{{ $contactSettings->phone2 }}</p>
                                    @endif
                                    @if($contactSettings->email)
                                        <p><a href="mailto:{{ $contactSettings->email }}">{{ $contactSettings->email }}</a></p>
                                    @endif
                                </div>
                            </div>
                            <div class="contact-info-item social-icons-item mb-0 pb-0">
                                <div class="content">
                                    <div class="social-widget">
                                        @if($contactSettings->facebook_url)
                                            <a href="{{ $contactSettings->facebook_url }}" target="_blank"><i class="lastudioicon lastudioicon-b-facebook"></i></a>
                                        @endif
                                        @if($contactSettings->instagram_url)
                                            <a href="{{ $contactSettings->instagram_url }}" target="_blank"><i class="lastudioicon lastudioicon-b-instagram"></i></a>
                                        @endif
                                        @if($contactSettings->pinterest_url)
                                            <a href="{{ $contactSettings->pinterest_url }}" target="_blank"><i class="lastudioicon lastudioicon-b-pinterest"></i></a>
                                        @endif
                                        @if($contactSettings->twitter_url)
                                            <a href="{{ $contactSettings->twitter_url }}" target="_blank"><i class="lastudioicon lastudioicon-b-twitter"></i></a>
                                        @endif
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
<!--== End Contact Area ==-->

<!--== Start Map Area ==-->
@if($contactSettings->map_embed_url)
<div class="contact-map-area">
    <iframe src="{{ $contactSettings->map_embed_url }}" 
            width="100%" 
            height="450" 
            style="border:0;" 
            allowfullscreen="" 
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"></iframe>
</div>
@endif
<!--== End Map Area ==-->

@push('scripts')
<script>
(function() {
    'use strict';
    
    // Reset button immediately
    const submitBtn = document.getElementById('submit-btn');
    if (submitBtn) {
        submitBtn.disabled = false;
        submitBtn.innerHTML = 'Send Message';
    }
    
    // Scroll to success message if present
    if (window.location.search.includes('submitted=success') || document.querySelector('.success-alert')) {
        setTimeout(function() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }, 300);
    }
    
    // Handle form submission
    const form = document.getElementById('contact-form');
    if (form && submitBtn) {
        form.addEventListener('submit', function(e) {
            if (submitBtn.disabled) {
                e.preventDefault();
                return false;
            }
            
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Sending...';
        });
    }
    
    // Force button reset on all page events
    window.addEventListener('pageshow', function() {
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Send Message';
        }
    });
    
    document.addEventListener('visibilitychange', function() {
        if (!document.hidden && submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Send Message';
        }
    });
    
    // Backup reset after 1 second
    setTimeout(function() {
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Send Message';
        }
    }, 1000);
})();
</script>
@endpush
@endsection