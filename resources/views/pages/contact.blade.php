@extends('layouts.app')

@section('title', 'Contact Us - Artfauj')

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
        {{-- Success Message --}}
        @if(session('success'))
        <div class="row">
            <div class="col-12">
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="background: #d4edda; border: 2px solid #28a745; border-radius: 10px; padding: 25px; margin-bottom: 30px; box-shadow: 0 4px 15px rgba(40,167,69,0.2);">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <div style="font-size: 40px; color: #28a745;">
                            ✅
                        </div>
                        <div>
                            <h4 style="color: #155724; margin: 0 0 5px 0; font-weight: bold;">
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
                                           placeholder="Name*" 
                                           value="{{ old('con_name') }}" 
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
                                           placeholder="Email*" 
                                           value="{{ old('con_email') }}" 
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
                                           placeholder="Phone Number"
                                           value="{{ old('con_phone') }}">
                                    @error('con_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-0">
                                    <textarea class="form-control textarea @error('con_message') is-invalid @enderror" 
                                              name="con_message" 
                                              placeholder="How can we help?" 
                                              required>{{ old('con_message') }}</textarea>
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
            loading="lazy"></iframe>
</div>
@endif
<!--== End Map Area ==-->

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('contact-form');
    const submitBtn = document.getElementById('submit-btn');
    
    // Check if there's a success message and show alert
    @if(session('contact_submitted'))
        // Scroll to top
        window.scrollTo({ top: 0, behavior: 'smooth' });
        
        // Show alert
        alert('✅ Your message has been sent successfully!\n\nWe will respond within 24-48 hours.');
        
        // Clear the form
        if (form) {
            form.reset();
        }
    @endif
    
    // Handle form submission
    if (form && submitBtn) {
        form.addEventListener('submit', function(e) {
            // Change button text to show loading
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Sending...';
            
            // Don't prevent default - let form submit normally
        });
    }
    
    // Reset button on page load (in case of back button)
    if (submitBtn) {
        submitBtn.disabled = false;
        submitBtn.innerHTML = 'Send Message';
    }
    
    // Handle errors
    @if($errors->any())
        // Scroll to error
        window.scrollTo({ top: 0, behavior: 'smooth' });
        
        // Reset button
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Send Message';
        }
    @endif
});

// Reset button when page visibility changes (prevents stuck spinner)
document.addEventListener('visibilitychange', function() {
    if (!document.hidden) {
        const submitBtn = document.getElementById('submit-btn');
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Send Message';
        }
    }
});

// Reset button on page show (handles back/forward navigation)
window.addEventListener('pageshow', function(event) {
    const submitBtn = document.getElementById('submit-btn');
    if (submitBtn) {
        submitBtn.disabled = false;
        submitBtn.innerHTML = 'Send Message';
    }
});
</script>
@endsection