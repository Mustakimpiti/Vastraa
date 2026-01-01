@extends('layouts.app')

@section('title', 'About Us - Artfauj')

@section('content')
<!--== Start Page Title Area ==-->
<section class="page-title-area bg-img" style="background-image: url('{{ asset('assets/img/about/2.jpg') }}'); background-attachment: fixed; background-position: center; background-size: cover; padding: 140px 0 100px; position: relative;">
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0, 0, 0, 0.5);"></div>
    <div class="container" style="position: relative; z-index: 1;">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-title-content text-center">
                    <h1 class="title text-white mb-0" style="font-size: 48px; font-weight: 700; letter-spacing: -1px;">About Artfauj</h1>
                </div>
            </div>
        </div>
    </div>
</section>
<!--== End Page Title Area ==-->

<!--== Start Welcome Section ==-->
<section class="welcome-section" style="padding: 100px 0;">
    <div class="container">
        <div class="row align-items-center g-4 g-lg-5">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="video-wrapper" style="position: relative; border-radius: 16px; overflow: hidden; box-shadow: 0 20px 60px rgba(0,0,0,0.15); aspect-ratio: 16/9;">
                    <img src="{{ asset('assets/img/photos/video2.jpg') }}" alt="Artfauj" class="img-fluid" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                    <a class="btn-play" href="https://www.youtube.com/watch?v=MLpWrANjFbI" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 10; text-decoration: none;">
                        <div class="play-button" style="width: 80px; height: 80px; background: rgba(255,255,255,0.95); border-radius: 50%; display: flex; align-items: center; justify-content: center; transition: all 0.3s ease; box-shadow: 0 8px 24px rgba(0,0,0,0.2);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="currentColor" style="color: #000; margin-left: 3px;">
                                <path d="M8 5v14l11-7z"/>
                            </svg>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="content-wrapper">
                    <h2 class="section-title mb-4" style="font-size: 42px; font-weight: 700; line-height: 1.2; color: #1a1a1a;">Welcome to <span style="display: block; color: #000;">Artfauj</span></h2>
                    <p class="lead mb-4" style="font-size: 16px; line-height: 1.8; color: #555;">Artfauj is a contemporary fashion brand created to address the unique wardrobe needs of today's working professional women. Built on the belief that everyday style should be effortless, expressive, and accessible, Artfauj offers designer sarees crafted for modern life—elegant enough for the workplace, stylish enough for social occasions, and comfortable enough for all-day wear.</p>
                    <p class="mb-4" style="font-size: 16px; line-height: 1.8; color: #555;">Every saree at Artfauj is the result of a thoughtful design journey. From initial inspiration and theme development to mood boards and meticulous detailing, each piece is crafted with intention and artistic depth.</p>
                    <p style="font-size: 16px; line-height: 1.8; color: #555;">Founded with a vision to blend India's heritage with modern sensibilities, Artfauj stands for creativity, quality, and everyday luxury. Artfauj is more than a brand; it is a movement to celebrate Indian craftsmanship through a fresh, contemporary lens.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!--== End Welcome Section ==-->

<!--== Start Why Choose Us Area ==-->
<section class="why-choose-section" style="padding: 100px 0; background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center mb-5 pb-3">
                <h2 class="section-title mb-3" style="font-size: 42px; font-weight: 700; color: #1a1a1a;">Why Choose Us</h2>
                <p style="font-size: 16px; color: #666; max-width: 600px; margin: 0 auto;">Discover what makes Artfauj the perfect choice for the modern professional woman</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="feature-card h-100" style="background: #fff; padding: 40px 30px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); transition: all 0.3s ease; border: 1px solid #f0f0f0;">
                    <div class="icon-wrapper mb-4" style="width: 60px; height: 60px; background: #000; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </div>
                    <h4 class="mb-3" style="font-size: 20px; font-weight: 600; color: #1a1a1a;">Designed for Working Women</h4>
                    <p style="font-size: 15px; line-height: 1.7; color: #666; margin: 0;">Our sarees are crafted to meet the lifestyle needs of today's professionals—comfortable for long hours and stylish for every setting.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="feature-card h-100" style="background: #fff; padding: 40px 30px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); transition: all 0.3s ease; border: 1px solid #f0f0f0;">
                    <div class="icon-wrapper mb-4" style="width: 60px; height: 60px; background: #000; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 2L2 7l10 5 10-5-10-5z"></path>
                            <path d="M2 17l10 5 10-5"></path>
                            <path d="M2 12l10 5 10-5"></path>
                        </svg>
                    </div>
                    <h4 class="mb-3" style="font-size: 20px; font-weight: 600; color: #1a1a1a;">Contemporary Meets Traditional</h4>
                    <p style="font-size: 15px; line-height: 1.7; color: #666; margin: 0;">We blend India's timeless textile heritage with modern design sensibilities to create sarees that feel fresh, relevant, and unique.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="feature-card h-100" style="background: #fff; padding: 40px 30px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); transition: all 0.3s ease; border: 1px solid #f0f0f0;">
                    <div class="icon-wrapper mb-4" style="width: 60px; height: 60px; background: #000; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="1" x2="12" y2="23"></line>
                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                        </svg>
                    </div>
                    <h4 class="mb-3" style="font-size: 20px; font-weight: 600; color: #1a1a1a;">Affordable Designer Quality</h4>
                    <p style="font-size: 15px; line-height: 1.7; color: #666; margin: 0;">Premium fabrics, thoughtful design, and accessibility define our value. You experience designer craftsmanship without the designer price tag.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="feature-card h-100" style="background: #fff; padding: 40px 30px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); transition: all 0.3s ease; border: 1px solid #f0f0f0;">
                    <div class="icon-wrapper mb-4" style="width: 60px; height: 60px; background: #000; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                            <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                            <line x1="12" y1="22.08" x2="12" y2="12"></line>
                        </svg>
                    </div>
                    <h4 class="mb-3" style="font-size: 20px; font-weight: 600; color: #1a1a1a;">Creative Depth in Every Piece</h4>
                    <p style="font-size: 15px; line-height: 1.7; color: #666; margin: 0;">Each saree is developed through a full creative process—theme boards, mood boards, sketches, and detailed design work.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="feature-card h-100" style="background: #fff; padding: 40px 30px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); transition: all 0.3s ease; border: 1px solid #f0f0f0;">
                    <div class="icon-wrapper mb-4" style="width: 60px; height: 60px; background: #000; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                    </div>
                    <h4 class="mb-3" style="font-size: 20px; font-weight: 600; color: #1a1a1a;">Versatility for Every Occasion</h4>
                    <p style="font-size: 15px; line-height: 1.7; color: #666; margin: 0;">From office days to small gatherings, kitty parties, dinners, and celebrations, our sarees transition effortlessly across everyday moments.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="feature-card h-100" style="background: #fff; padding: 40px 30px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); transition: all 0.3s ease; border: 1px solid #f0f0f0;">
                    <div class="icon-wrapper mb-4" style="width: 60px; height: 60px; background: #000; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                        </svg>
                    </div>
                    <h4 class="mb-3" style="font-size: 20px; font-weight: 600; color: #1a1a1a;">Stand Out with Confidence</h4>
                    <p style="font-size: 15px; line-height: 1.7; color: #666; margin: 0;">Artfauj sarees are crafted to make you feel elegant, modern, and uniquely yourself, wherever you go.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!--== End Why Choose Us Area ==-->

<!--== Start Our Process Area ==-->
<section class="process-section" style="padding: 100px 0;">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center mb-5 pb-3">
                <h2 class="section-title mb-3" style="font-size: 42px; font-weight: 700; color: #1a1a1a;">Our Process</h2>
                <p style="font-size: 16px; line-height: 1.8; color: #666; max-width: 700px; margin: 0 auto;">At Artfauj, every saree begins with a story. Our design process is rooted in creativity, research, and craftsmanship, ensuring that each piece is both contemporary and meaningful.</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="process-card h-100" style="background: #fff; padding: 40px 30px; border-radius: 16px; border: 2px solid #f0f0f0; transition: all 0.3s ease; position: relative; overflow: hidden;">
                    <div class="step-number mb-4" style="width: 50px; height: 50px; background: #000; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 20px; font-weight: 700;">1</div>
                    <h4 class="mb-3" style="font-size: 20px; font-weight: 600; color: #1a1a1a;">Inspiration & Theme Development</h4>
                    <p style="font-size: 15px; line-height: 1.7; color: #666; margin: 0;">We begin by exploring artistic references, cultural elements, and modern trends to define a strong theme for each collection.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="process-card h-100" style="background: #fff; padding: 40px 30px; border-radius: 16px; border: 2px solid #f0f0f0; transition: all 0.3s ease; position: relative; overflow: hidden;">
                    <div class="step-number mb-4" style="width: 50px; height: 50px; background: #000; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 20px; font-weight: 700;">2</div>
                    <h4 class="mb-3" style="font-size: 20px; font-weight: 600; color: #1a1a1a;">Mood Boards & Concept Building</h4>
                    <p style="font-size: 15px; line-height: 1.7; color: #666; margin: 0;">Visual mood boards help refine the overall palette, motifs, textures, and emotions that guide the final design direction.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="process-card h-100" style="background: #fff; padding: 40px 30px; border-radius: 16px; border: 2px solid #f0f0f0; transition: all 0.3s ease; position: relative; overflow: hidden;">
                    <div class="step-number mb-4" style="width: 50px; height: 50px; background: #000; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 20px; font-weight: 700;">3</div>
                    <h4 class="mb-3" style="font-size: 20px; font-weight: 600; color: #1a1a1a;">Fabric Selection</h4>
                    <p style="font-size: 15px; line-height: 1.7; color: #666; margin: 0;">Our sarees are crafted from high-quality, comfortable fabrics chosen for durability, drape, and everyday ease. New fabric variations will be introduced soon.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="process-card h-100" style="background: #fff; padding: 40px 30px; border-radius: 16px; border: 2px solid #f0f0f0; transition: all 0.3s ease; position: relative; overflow: hidden;">
                    <div class="step-number mb-4" style="width: 50px; height: 50px; background: #000; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 20px; font-weight: 700;">4</div>
                    <h4 class="mb-3" style="font-size: 20px; font-weight: 600; color: #1a1a1a;">Detailed Design Execution</h4>
                    <p style="font-size: 15px; line-height: 1.7; color: #666; margin: 0;">Each saree undergoes careful sketching, pattern refinement, and creative detailing to achieve the perfect balance of elegance and modernity.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="process-card h-100" style="background: #fff; padding: 40px 30px; border-radius: 16px; border: 2px solid #f0f0f0; transition: all 0.3s ease; position: relative; overflow: hidden;">
                    <div class="step-number mb-4" style="width: 50px; height: 50px; background: #000; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 20px; font-weight: 700;">5</div>
                    <h4 class="mb-3" style="font-size: 20px; font-weight: 600; color: #1a1a1a;">Finishing & Quality Check</h4>
                    <p style="font-size: 15px; line-height: 1.7; color: #666; margin: 0;">Before reaching you, every saree is inspected to ensure superior finish, comfort, and craftsmanship.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="process-card h-100" style="background: linear-gradient(135deg, #1a1a1a 0%, #333 100%); padding: 40px 30px; border-radius: 16px; transition: all 0.3s ease; display: flex; align-items: center; justify-content: center;">
                    <div class="text-center">
                        <p style="font-size: 16px; line-height: 1.7; color: #fff; margin: 0; font-weight: 600;">Artfauj's process is driven by passion, precision, and a commitment to creating everyday designer wear that stands out effortlessly.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--== End Our Process Area ==-->

<!--== Start Founder Area ==-->
<section class="founder-section" style="padding: 100px 0; background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center mb-5 pb-3">
                <h2 class="section-title mb-3" style="font-size: 42px; font-weight: 700; color: #1a1a1a;">Meet Our Founder</h2>
                <p style="font-size: 16px; color: #666;">The creative vision behind Artfauj</p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-11">
                <div class="founder-card" style="background: #fff; border-radius: 20px; overflow: hidden; box-shadow: 0 10px 40px rgba(0,0,0,0.1);">
                    <div class="row g-0">
                        <div class="col-lg-5">
                            <div class="founder-image" style="height: 100%; min-height: 500px; background-image: url('{{ asset('assets/img/team/founder.jpg') }}'); background-size: cover; background-position: center top;"></div>
                        </div>
                        <div class="col-lg-7">
                            <div class="founder-content" style="padding: 60px 50px;">
                                <h3 class="mb-2" style="font-size: 32px; font-weight: 700; color: #1a1a1a;">Amol Upadhyay</h3>
                                <p class="subtitle mb-4" style="font-size: 14px; color: #000; font-weight: 600; text-transform: uppercase; letter-spacing: 1px;">Founder | Fashion Designer | Mentor | Creative Visionary</p>
                                <div class="founder-bio" style="font-size: 15px; line-height: 1.8; color: #555;">
                                    <p class="mb-3">Amol Upadhyay is a Vadodara-based fashion designer with over 22 years of experience in fashion, design, and creative education. Known for his distinctive abstract aesthetic, he seamlessly blends bold artistic expression with contemporary design sensibilities. His work has been featured in esteemed publications such as Femina, and he has successfully curated and executed 50+ exhibitions across India.</p>
                                    <p class="mb-3">For a decade, Amol served as the Center Director of JD Institute of Fashion Technology, Vadodara, where his leadership and mentorship played a pivotal role in shaping the careers of thousands of aspiring designers. His commitment to excellence in fashion education has been widely recognized, including the Best Design Institute in Vadodara (2018) award presented by Soha Ali Khan, and the International Glory Award (2019) presented by Madhuri Dixit Nene in Goa.</p>
                                    <p class="mb-3">As the Founder of Artfauj, Amol is now channeling his creative vision into the digital and collaborative space. Artfauj is a purpose-driven platform aimed at building a collective of artisans and reviving India's rich handloom and craft heritage, thoughtfully reimagined through a refined, modern lens.</p>
                                    <p class="mb-0" style="font-weight: 600; color: #1a1a1a;">Driven by creativity, mentorship, and cultural storytelling, Amol continues to inspire the next generation of designers while championing sustainable and meaningful fashion.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--== End Founder Area ==-->

@push('styles')
<style>
    /* Play Button Hover Effect */
    .btn-play .play-button:hover {
        background: rgba(255,255,255,1);
        transform: scale(1.1);
        box-shadow: 0 12px 32px rgba(0,0,0,0.3);
    }
    
    /* Feature Card Hover Effect */
    .feature-card {
        cursor: pointer;
    }
    
    .feature-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 40px rgba(0,0,0,0.15) !important;
        border-color: #000 !important;
    }
    
    .feature-card:hover .icon-wrapper {
        transform: scale(1.1) rotate(5deg);
    }
    
    .icon-wrapper {
        transition: all 0.3s ease;
    }
    
    /* Process Card Hover Effect */
    .process-card:hover {
        transform: translateY(-8px);
        border-color: #000 !important;
        box-shadow: 0 12px 40px rgba(0,0,0,0.12);
    }
    
    /* Responsive Typography */
    @media (max-width: 991px) {
        .section-title {
            font-size: 36px !important;
        }
        
        h1.title {
            font-size: 38px !important;
        }
        
        .founder-content {
            padding: 40px 30px !important;
        }
        
        .founder-image {
            min-height: 400px !important;
        }
    }
    
    @media (max-width: 767px) {
        .page-title-area {
            padding: 100px 0 70px !important;
        }
        
        h1.title {
            font-size: 32px !important;
        }
        
        .section-title {
            font-size: 30px !important;
        }
        
        .welcome-section,
        .why-choose-section,
        .process-section,
        .founder-section {
            padding: 70px 0 !important;
        }
        
        .content-wrapper h2 {
            font-size: 32px !important;
        }
        
        .feature-card,
        .process-card {
            padding: 30px 25px !important;
        }
        
        .founder-content {
            padding: 30px 25px !important;
        }
        
        .founder-image {
            min-height: 350px !important;
        }
        
        .founder-content h3 {
            font-size: 26px !important;
        }
        
        .play-button {
            width: 70px !important;
            height: 70px !important;
        }
        
        .play-button svg {
            width: 28px !important;
            height: 28px !important;
        }
        
        .video-wrapper {
            aspect-ratio: 4/3 !important;
        }
    }
    
    @media (max-width: 575px) {
        .page-title-area {
            padding: 80px 0 60px !important;
        }
        
        h1.title {
            font-size: 28px !important;
        }
        
        .section-title {
            font-size: 26px !important;
        }
        
        .feature-card,
        .process-card {
            padding: 25px 20px !important;
        }
        
        .icon-wrapper,
        .step-number {
            width: 50px !important;
            height: 50px !important;
        }
        
        .icon-wrapper svg {
            width: 24px !important;
            height: 24px !important;
        }
        
        .founder-content {
            padding: 25px 20px !important;
        }
        
        .video-wrapper {
            border-radius: 12px !important;
        }
    }
</style>
@endpush
@endsection