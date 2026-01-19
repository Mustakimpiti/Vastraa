@extends('layouts.app')

@section('title', 'Trending Videos')

@section('content')
<div class="videos-container">
    <div class="videos-wrapper" id="videosWrapper">
        @foreach($videos as $index => $video)
        <div class="video-slide" data-index="{{ $index }}">
            <video 
                id="video-{{ $index }}" 
                class="fullscreen-video" 
                playsinline 
                loop 
                preload="auto"
                {{ $index === 0 ? 'autoplay' : '' }}
            >
                <source src="{{ asset($video->video_path) }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            
            <!-- Video Info Overlay -->
            <div class="video-info">
                <h3>{{ $video->title }}</h3>
                @if($video->description)
                <p>{{ $video->description }}</p>
                @endif
            </div>
            
            <!-- Controls -->
            <div class="video-controls">
                <button class="control-btn mute-btn" data-video="video-{{ $index }}">
                    <i class="fa fa-volume-up"></i>
                </button>
            </div>
            
            <!-- Scroll Indicator (only on first video) -->
            @if($index === 0)
            <div class="scroll-indicator">
                <i class="fa fa-chevron-down"></i>
                <span>Swipe up for more</span>
            </div>
            @endif
        </div>
        @endforeach
    </div>
    
    <!-- Navigation Dots -->
    <div class="video-dots">
        @foreach($videos as $index => $video)
        <span class="dot {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}"></span>
        @endforeach
    </div>
    
    <!-- Close Button -->
    <a href="{{ route('home') }}" class="close-viewer">
        <i class="fa fa-times"></i>
    </a>
</div>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.videos-container {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100vh;
    background: #000;
    overflow: hidden;
    z-index: 9999;
}

.videos-wrapper {
    width: 100%;
    height: 100vh;
    overflow-y: scroll;
    scroll-snap-type: y mandatory;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: none;
}

.videos-wrapper::-webkit-scrollbar {
    display: none;
}

.video-slide {
    position: relative;
    width: 100%;
    height: 100vh;
    scroll-snap-align: start;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #000;
}

.fullscreen-video {
    width: 100%;
    height: 100%;
    object-fit: contain;
    background: #000;
}

/* Video Info Overlay */
.video-info {
    position: absolute;
    bottom: 100px;
    left: 20px;
    right: 20px;
    color: white;
    z-index: 10;
    text-shadow: 0 2px 8px rgba(0, 0, 0, 0.8);
}

.video-info h3 {
    font-size: 24px;
    font-weight: 700;
    margin-bottom: 10px;
    color: #fff;
}

.video-info p {
    font-size: 16px;
    line-height: 1.5;
    color: #fff;
    opacity: 0.9;
}

/* Controls */
.video-controls {
    position: absolute;
    right: 20px;
    bottom: 150px;
    z-index: 10;
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.control-btn {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.3);
    backdrop-filter: blur(10px);
    border: none;
    color: white;
    font-size: 20px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.control-btn:hover {
    background: rgba(255, 255, 255, 0.5);
    transform: scale(1.1);
}

.control-btn.muted i:before {
    content: "\f026"; /* mute icon */
}

/* Scroll Indicator */
.scroll-indicator {
    position: absolute;
    bottom: 30px;
    left: 50%;
    transform: translateX(-50%);
    color: white;
    text-align: center;
    z-index: 10;
    animation: bounce 2s infinite;
}

.scroll-indicator i {
    font-size: 24px;
    display: block;
    margin-bottom: 5px;
}

.scroll-indicator span {
    font-size: 14px;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.8);
}

@keyframes bounce {
    0%, 20%, 50%, 80%, 100% {
        transform: translateX(-50%) translateY(0);
    }
    40% {
        transform: translateX(-50%) translateY(-10px);
    }
    60% {
        transform: translateX(-50%) translateY(-5px);
    }
}

/* Navigation Dots */
.video-dots {
    position: fixed;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    z-index: 11;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.5);
    cursor: pointer;
    transition: all 0.3s ease;
}

.dot.active {
    background: white;
    height: 24px;
    border-radius: 4px;
}

/* Close Button */
.close-viewer {
    position: fixed;
    top: 20px;
    left: 20px;
    width: 45px;
    height: 45px;
    border-radius: 50%;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(10px);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 20px;
    z-index: 12;
    text-decoration: none;
    transition: all 0.3s ease;
}

.close-viewer:hover {
    background: rgba(0, 0, 0, 0.8);
    transform: scale(1.1);
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .video-info h3 {
        font-size: 20px;
    }
    
    .video-info p {
        font-size: 14px;
    }
    
    .control-btn {
        width: 45px;
        height: 45px;
        font-size: 18px;
    }
    
    .video-controls {
        bottom: 120px;
        right: 15px;
    }
    
    .video-info {
        bottom: 80px;
        left: 15px;
        right: 15px;
    }
}

/* Landscape Mode */
@media (orientation: landscape) and (max-width: 1024px) {
    .fullscreen-video {
        object-fit: cover;
    }
    
    .video-info {
        bottom: 60px;
        left: 15px;
        max-width: 50%;
    }
    
    .video-controls {
        bottom: 80px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const wrapper = document.getElementById('videosWrapper');
    const videos = document.querySelectorAll('.fullscreen-video');
    const dots = document.querySelectorAll('.dot');
    const muteButtons = document.querySelectorAll('.mute-btn');
    let currentIndex = 0;
    let isScrolling = false;
    
    // Play first video with sound
    if (videos.length > 0) {
        videos[0].muted = false;
        videos[0].play();
    }
    
    // Mute/Unmute button
    muteButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const videoId = this.getAttribute('data-video');
            const video = document.getElementById(videoId);
            
            if (video.muted) {
                video.muted = false;
                this.classList.remove('muted');
            } else {
                video.muted = true;
                this.classList.add('muted');
            }
        });
    });
    
    // Update active video on scroll
    function updateActiveVideo() {
        const scrollPosition = wrapper.scrollTop;
        const windowHeight = window.innerHeight;
        const newIndex = Math.round(scrollPosition / windowHeight);
        
        if (newIndex !== currentIndex && newIndex >= 0 && newIndex < videos.length) {
            // Pause previous video
            videos[currentIndex].pause();
            videos[currentIndex].muted = true;
            muteButtons[currentIndex].classList.add('muted');
            
            // Update index
            currentIndex = newIndex;
            
            // Play new video with sound
            videos[currentIndex].muted = false;
            videos[currentIndex].play();
            muteButtons[currentIndex].classList.remove('muted');
            
            // Update dots
            dots.forEach((dot, index) => {
                dot.classList.toggle('active', index === currentIndex);
            });
            
            // Hide scroll indicator after first scroll
            const indicator = document.querySelector('.scroll-indicator');
            if (indicator && currentIndex > 0) {
                indicator.style.display = 'none';
            }
        }
    }
    
    // Scroll event listener with debouncing
    wrapper.addEventListener('scroll', function() {
        if (!isScrolling) {
            window.requestAnimationFrame(function() {
                updateActiveVideo();
                isScrolling = false;
            });
            isScrolling = true;
        }
    });
    
    // Click dots to navigate
    dots.forEach((dot, index) => {
        dot.addEventListener('click', function() {
            wrapper.scrollTo({
                top: index * window.innerHeight,
                behavior: 'smooth'
            });
        });
    });
    
    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (e.key === 'ArrowDown' && currentIndex < videos.length - 1) {
            wrapper.scrollTo({
                top: (currentIndex + 1) * window.innerHeight,
                behavior: 'smooth'
            });
        } else if (e.key === 'ArrowUp' && currentIndex > 0) {
            wrapper.scrollTo({
                top: (currentIndex - 1) * window.innerHeight,
                behavior: 'smooth'
            });
        } else if (e.key === 'Escape') {
            window.location.href = '{{ route("home") }}';
        } else if (e.key === ' ') {
            e.preventDefault();
            const video = videos[currentIndex];
            const btn = muteButtons[currentIndex];
            
            if (video.muted) {
                video.muted = false;
                btn.classList.remove('muted');
            } else {
                video.muted = true;
                btn.classList.add('muted');
            }
        }
    });
    
    // Handle visibility change
    document.addEventListener('visibilitychange', function() {
        if (document.hidden) {
            videos[currentIndex].pause();
        } else {
            videos[currentIndex].play();
        }
    });
    
    // Touch swipe support for mobile
    let touchStartY = 0;
    let touchEndY = 0;
    
    wrapper.addEventListener('touchstart', function(e) {
        touchStartY = e.touches[0].clientY;
    });
    
    wrapper.addEventListener('touchend', function(e) {
        touchEndY = e.changedTouches[0].clientY;
        handleSwipe();
    });
    
    function handleSwipe() {
        const swipeDistance = touchStartY - touchEndY;
        const threshold = 50;
        
        if (Math.abs(swipeDistance) > threshold) {
            if (swipeDistance > 0 && currentIndex < videos.length - 1) {
                // Swipe up - next video
                wrapper.scrollTo({
                    top: (currentIndex + 1) * window.innerHeight,
                    behavior: 'smooth'
                });
            } else if (swipeDistance < 0 && currentIndex > 0) {
                // Swipe down - previous video
                wrapper.scrollTo({
                    top: (currentIndex - 1) * window.innerHeight,
                    behavior: 'smooth'
                });
            }
        }
    }
});
</script>
@endsection