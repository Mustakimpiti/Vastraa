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
        <div class="row">
            <div class="col-lg-7">
                <div class="contact-form">
                    <form class="contact-form-wrapper form-style" id="contact-form" action="{{ url('/contact-submit') }}" method="post">
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
                                    <input class="form-control" type="text" name="con_name" placeholder="Name*" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input class="form-control" type="email" name="con_email" placeholder="Email*" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input class="form-control" type="text" name="con_phone" placeholder="Phone Number">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-0">
                                    <textarea class="form-control textarea" name="con_message" placeholder="How can we help?" required></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-0">
                                    <button class="btn btn-theme btn-black" type="submit">Send Message</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- Message Notification -->
                    <div class="form-message"></div>
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
                                    <p>F 316, Ananta Swagatam,<br>Bill Kalali Road,<br>Vadodara - 391410</p>
                                </div>
                            </div>
                        </div>
                        <div class="align-bottom">
                            <div class="contact-info-item">
                                <div class="icon">
                                    <span><i class="lastudioicon lastudioicon-phone-call-2"></i></span>
                                </div>
                                <div class="content">
                                    <p>+91 94267 24282</p>
                                    <p>+91 94294 08688</p>
                                </div>
                            </div>
                            <div class="contact-info-item social-icons-item mb-0 pb-0">
                                <div class="content">
                                    <div class="social-widget">
                                        <a href="#/"><i class="lastudioicon lastudioicon-b-facebook"></i></a>
                                        <a href="#/"><i class="lastudioicon lastudioicon-b-pinterest"></i></a>
                                        <a href="#/"><i class="lastudioicon lastudioicon-b-twitter"></i></a>
                                        <a href="#/"><i class="lastudioicon lastudioicon-b-instagram"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Taglines Section -->
                    {{-- <div class="taglines-section" style="margin-top: 30px; padding: 20px; background: #f9f9f9; border-left: 3px solid #333;">
                        <h5 style="margin-bottom: 15px; font-weight: 600;">Our Heritage</h5>
                        <ul style="list-style: none; padding: 0; font-size: 14px; line-height: 1.8; color: #555;">
                            <li style="margin-bottom: 8px;">✦ Saree swag, unstoppable spirit</li>
                            <li style="margin-bottom: 8px;">✦ Saree, but make it savage</li>
                            <li style="margin-bottom: 8px;">✦ Turning traditions into trends</li>
                            <li style="margin-bottom: 8px;">✦ A saree is poetry woven in threads</li>
                            <li style="margin-bottom: 8px;">✦ Grace in folds, strength in spirit</li>
                            <li style="margin-bottom: 8px;">✦ Saree: it's my statement</li>
                            <li style="margin-bottom: 8px;">✦ Not just fabric, it's heritage</li>
                        </ul>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</section>
<!--== End Contact Area ==-->

<!--== Start Map Area ==-->
<div class="contact-map-area">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3691.5447824536945!2d73.1627!3d22.3039!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjLCsDE4JzE0LjAiTiA3M8KwMDknNDUuNyJF!5e0!3m2!1sen!2sin!4v1234567890!5m2!1sen!2sin" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
</div>
<!--== End Map Area ==-->
@endsection