@extends('layouts.app')

@section('title', 'Service Rabbit - Get Help from Trusted Local Taskers')

@section('content')
<!-- Hero Banner Section -->
<section class="hero-banner">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-xl-7">
                <div class="hero-content-wrapper">
                    <h1 class="hero-banner-title">
                        Get Help from <span class="highlight">Trusted Taskers</span> Near You
                    </h1>
                    <p class="hero-banner-subtitle">
                        From home repairs to cleaning, moving to delivery — connect with skilled professionals ready to tackle any task. Book trusted help in minutes.
                    </p>
                    
                    <!-- Search Box -->
                    <form action="{{ route('search') }}" method="GET" class="search-box-hero">
                        <div class="search-box-inner">
                            <div class="search-input-wrapper">
                                <i class="bi bi-search"></i>
                                <input type="text" name="q" placeholder="What do you need help with?">
                            </div>
                            <div class="search-input-wrapper">
                                <i class="bi bi-geo-alt"></i>
                                <input type="text" name="location" placeholder="Enter your location">
                            </div>
                            <button type="submit" class="search-btn-hero">
                                <i class="bi bi-search"></i>
                                Search
                            </button>
                        </div>
                    </form>
                    
                    <!-- Popular Services -->
                    <div class="popular-services">
                        <span class="popular-services-label">Popular:</span>
                        <a href="{{ route('search', ['q' => 'cleaning']) }}" class="service-tag">
                            <i class="bi bi-droplet"></i> Cleaning
                        </a>
                        <a href="{{ route('search', ['q' => 'handyman']) }}" class="service-tag">
                            <i class="bi bi-tools"></i> Handyman
                        </a>
                        <a href="{{ route('search', ['q' => 'moving']) }}" class="service-tag">
                            <i class="bi bi-truck"></i> Moving
                        </a>
                        <a href="{{ route('search', ['q' => 'delivery']) }}" class="service-tag">
                            <i class="bi bi-box-seam"></i> Delivery
                        </a>
                        <a href="{{ route('search', ['q' => 'assembly']) }}" class="service-tag">
                            <i class="bi bi-puzzle"></i> Assembly
                        </a>
                    </div>
                    
                    <!-- Hero Stats -->
                    <div class="hero-stats">
                        <div class="hero-stat-item">
                            <div class="hero-stat-value">{{ isset($stats['total_users']) && $stats['total_users'] > 0 ? number_format($stats['total_users']) : '10,000' }}<span>+</span></div>
                            <div class="hero-stat-label">Happy Customers</div>
                        </div>
                        <div class="hero-stat-item">
                            <div class="hero-stat-value">{{ isset($stats['total_taskers']) && $stats['total_taskers'] > 0 ? number_format($stats['total_taskers']) : '500' }}<span>+</span></div>
                            <div class="hero-stat-label">Verified Taskers</div>
                        </div>
                        <div class="hero-stat-item">
                            <div class="hero-stat-value">4.9<span>/5</span></div>
                            <div class="hero-stat-label">Average Rating</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Premium Services Section -->
<section class="services-premium">
    <div class="container">
        <div class="section-header-premium">
            <span class="section-label">
                <i class="bi bi-grid-3x3-gap-fill"></i>
                Our Services
            </span>
            <h2 class="section-title-premium">Popular Service Categories</h2>
            <p class="section-desc-premium">
                Browse through our most requested services and find the perfect tasker for your needs
            </p>
        </div>
        
        <div class="row g-4">
            @php
                $services = [
                    ['name' => 'House Cleaning', 'icon' => 'bi-droplet', 'class' => 'cleaning', 'price' => '25', 'tasks' => '2.5k', 'desc' => 'Professional deep cleaning'],
                    ['name' => 'Handyman', 'icon' => 'bi-tools', 'class' => 'handyman', 'price' => '35', 'tasks' => '1.8k', 'desc' => 'Repairs & maintenance'],
                    ['name' => 'Moving Help', 'icon' => 'bi-truck', 'class' => 'moving', 'price' => '45', 'tasks' => '1.2k', 'desc' => 'Local moving assistance'],
                    ['name' => 'Delivery', 'icon' => 'bi-box-seam', 'class' => 'delivery', 'price' => '20', 'tasks' => '3.1k', 'desc' => 'Same-day delivery'],
                    ['name' => 'Assembly', 'icon' => 'bi-puzzle', 'class' => 'assembly', 'price' => '30', 'tasks' => '980', 'desc' => 'Furniture building'],
                    ['name' => 'Painting', 'icon' => 'bi-paint-bucket', 'class' => 'painting', 'price' => '40', 'tasks' => '750', 'desc' => 'Interior & exterior'],
                    ['name' => 'Plumbing', 'icon' => 'bi-water', 'class' => 'plumbing', 'price' => '55', 'tasks' => '620', 'desc' => 'Leak repairs & more'],
                    ['name' => 'Electrical', 'icon' => 'bi-lightning', 'class' => 'electrical', 'price' => '50', 'tasks' => '540', 'desc' => 'Wiring & fixtures'],
                ];
            @endphp
            
            @foreach($services as $service)
                <div class="col-6 col-md-4 col-lg-3">
                    <a href="{{ route('search', ['q' => $service['name']]) }}" class="service-card-premium">
                        <div class="service-icon-premium {{ $service['class'] }}">
                            <i class="bi {{ $service['icon'] }}"></i>
                        </div>
                        <h5>{{ $service['name'] }}</h5>
                        <p>{{ $service['desc'] }}</p>
                        <div class="service-meta">
                            <div class="service-meta-item">
                                <i class="bi bi-check-circle"></i>
                                {{ $service['tasks'] }}+
                            </div>
                            <div class="service-meta-item price">
                                ${{ $service['price'] }}/hr
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
        
        <div class="text-center mt-5">
            <a href="{{ route('categories.index') }}" class="btn btn-outline-primary btn-lg px-5">
                View All Categories <i class="bi bi-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

<!-- How It Works -->
<section class="how-it-works-section" id="how-it-works">
    <div class="container">
        <div class="section-header-premium">
            <span class="section-label">
                <i class="bi bi-lightning-fill"></i>
                Simple Process
            </span>
            <h2 class="section-title-premium">How It Works</h2>
            <p class="section-desc-premium">
                Get your tasks done in just 4 simple steps
            </p>
        </div>
        
        <div class="row g-4 pt-4">
            <div class="col-md-6 col-lg-3">
                <div class="step-card-premium">
                    <div class="step-number-badge step-1">1</div>
                    <div class="step-icon-box icon-1">
                        <i class="bi bi-search"></i>
                    </div>
                    <h4>Describe Your Task</h4>
                    <p>Tell us what you need done, when and where. Be as detailed as possible.</p>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-3">
                <div class="step-card-premium">
                    <div class="step-number-badge step-2">2</div>
                    <div class="step-icon-box icon-2">
                        <i class="bi bi-person-check"></i>
                    </div>
                    <h4>Choose Your Tasker</h4>
                    <p>Browse profiles, read reviews and select the perfect tasker for your job.</p>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-3">
                <div class="step-card-premium">
                    <div class="step-number-badge step-3">3</div>
                    <div class="step-icon-box icon-3">
                        <i class="bi bi-calendar-check"></i>
                    </div>
                    <h4>Book & Schedule</h4>
                    <p>Confirm your booking and pay securely through the app.</p>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-3">
                <div class="step-card-premium">
                    <div class="step-number-badge step-4">4</div>
                    <div class="step-icon-box icon-4">
                        <i class="bi bi-emoji-smile"></i>
                    </div>
                    <h4>Get It Done!</h4>
                    <p>Your tasker completes the job. Rate and review to help others.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Taskers -->
@if(isset($taskers) && $taskers->isNotEmpty())
<section class="taskers-premium">
    <div class="container">
        <div class="section-header-premium">
            <span class="section-label">
                <i class="bi bi-award-fill"></i>
                Top Rated
            </span>
            <h2 class="section-title-premium">Featured Taskers</h2>
            <p class="section-desc-premium">
                Meet some of our highest-rated service professionals
            </p>
        </div>
        
        <div class="row g-4">
            @foreach($taskers->take(4) as $tasker)
                <div class="col-md-6 col-lg-3">
                    <div class="tasker-card-premium">
                        <div class="tasker-card-header">
                            <span class="tasker-verified-badge">
                                <i class="bi bi-patch-check-fill"></i> Verified
                            </span>
                            <div class="tasker-avatar-premium">
                                @if($tasker->avatar)
                                    <img src="{{ Storage::url($tasker->avatar) }}" alt="{{ $tasker->first_name }}">
                                @else
                                    {{ strtoupper(substr($tasker->first_name, 0, 1)) }}{{ strtoupper(substr($tasker->last_name, 0, 1)) }}
                                @endif
                            </div>
                        </div>
                        
                        <div class="tasker-card-body">
                            <h5 class="tasker-name-premium">{{ $tasker->first_name }} {{ substr($tasker->last_name, 0, 1) }}.</h5>
                            <p class="tasker-headline">{{ $tasker->taskerProfile->headline ?? 'Professional Tasker' }}</p>
                            
                            <div class="tasker-rating-premium">
                                <span class="stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="bi bi-star{{ $i <= ($tasker->taskerProfile->average_rating ?? 5) ? '-fill' : '' }}"></i>
                                    @endfor
                                </span>
                                <span class="rating-value">{{ number_format($tasker->taskerProfile->average_rating ?? 5, 1) }}</span>
                                <span class="review-count">({{ $tasker->taskerProfile->total_reviews ?? 0 }})</span>
                            </div>
                            
                            <div class="tasker-stats-premium">
                                <div class="tasker-stat-item">
                                    <div class="value">{{ $tasker->taskerProfile->total_completed_tasks ?? 0 }}</div>
                                    <div class="label">Tasks</div>
                                </div>
                                <div class="tasker-stat-item">
                                    <div class="value">{{ $tasker->taskerProfile->years_experience ?? 1 }}+</div>
                                    <div class="label">Years</div>
                                </div>
                                <div class="tasker-stat-item">
                                    <div class="value">98%</div>
                                    <div class="label">Success</div>
                                </div>
                            </div>
                            
                            <div class="tasker-price-premium">
                                ${{ number_format($tasker->taskerProfile->hourly_rate ?? 35, 0) }}<span>/hr</span>
                            </div>
                            
                            <a href="{{ route('taskers.show', $tasker->id) }}" class="btn-book-tasker">
                                <i class="bi bi-calendar-plus"></i>
                                Book Now
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="text-center mt-5">
            <a href="{{ route('taskers.index') }}" class="btn btn-outline-primary btn-lg px-5">
                Browse All Taskers <i class="bi bi-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>
@endif

<!-- Stats Section -->
<section class="stats-premium">
    <div class="container">
        <div class="row">
            <div class="col-6 col-lg-3">
                <div class="stat-card-premium">
                    <div class="stat-icon-premium icon-1">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div class="stat-value-premium">{{ isset($stats['total_users']) && $stats['total_users'] > 0 ? number_format($stats['total_users']) : '10,000' }}+</div>
                    <div class="stat-label-premium">Happy Customers</div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="stat-card-premium">
                    <div class="stat-icon-premium icon-2">
                        <i class="bi bi-person-badge-fill"></i>
                    </div>
                    <div class="stat-value-premium">{{ isset($stats['total_taskers']) && $stats['total_taskers'] > 0 ? number_format($stats['total_taskers']) : '500' }}+</div>
                    <div class="stat-label-premium">Verified Taskers</div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="stat-card-premium">
                    <div class="stat-icon-premium icon-3">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <div class="stat-value-premium">{{ isset($stats['total_bookings']) && $stats['total_bookings'] > 0 ? number_format($stats['total_bookings']) : '25,000' }}+</div>
                    <div class="stat-label-premium">Tasks Completed</div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="stat-card-premium">
                    <div class="stat-icon-premium icon-4">
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <div class="stat-value-premium">4.9</div>
                    <div class="stat-label-premium">Average Rating</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="testimonials-premium">
    <div class="container">
        <div class="section-header-premium">
            <span class="section-label">
                <i class="bi bi-chat-quote-fill"></i>
                Testimonials
            </span>
            <h2 class="section-title-premium">What Our Customers Say</h2>
            <p class="section-desc-premium">
                Real reviews from real customers
            </p>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="testimonial-card-premium">
                    <div class="testimonial-quote-icon">
                        <i class="bi bi-quote"></i>
                    </div>
                    <p class="testimonial-text-premium">
                        "Amazing service! The tasker arrived on time, was super professional, and did an excellent job cleaning my apartment. Will definitely use again!"
                    </p>
                    <div class="testimonial-author-premium">
                        <div class="testimonial-avatar-premium">JD</div>
                        <div class="testimonial-info">
                            <h6>Jessica Davis</h6>
                            <p>House Cleaning</p>
                            <div class="testimonial-rating-premium">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="testimonial-card-premium">
                    <div class="testimonial-quote-icon">
                        <i class="bi bi-quote"></i>
                    </div>
                    <p class="testimonial-text-premium">
                        "Found a great handyman through Service Rabbit. He fixed multiple things around my house in just a few hours. Great value!"
                    </p>
                    <div class="testimonial-author-premium">
                        <div class="testimonial-avatar-premium" style="background: linear-gradient(135deg, #10b981, #34d399);">MK</div>
                        <div class="testimonial-info">
                            <h6>Michael Kim</h6>
                            <p>Handyman Service</p>
                            <div class="testimonial-rating-premium">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="testimonial-card-premium">
                    <div class="testimonial-quote-icon">
                        <i class="bi bi-quote"></i>
                    </div>
                    <p class="testimonial-text-premium">
                        "Moving was so stressful until I found these guys. They made the whole process smooth and easy. Highly recommend!"
                    </p>
                    <div class="testimonial-author-premium">
                        <div class="testimonial-avatar-premium" style="background: linear-gradient(135deg, #f59e0b, #fbbf24);">SR</div>
                        <div class="testimonial-info">
                            <h6>Sarah Robinson</h6>
                            <p>Moving Help</p>
                            <div class="testimonial-rating-premium">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-premium">
    <div class="container">
        <div class="cta-content-premium">
            <h2 class="cta-title-premium">Ready to Get Started?</h2>
            <p class="cta-subtitle-premium">
                Join thousands of happy customers who trust Service Rabbit for their everyday tasks.
            </p>
            <div class="cta-buttons-premium">
                <a href="{{ route('register') }}" class="btn-cta-white">
                    <i class="bi bi-person-plus-fill"></i>
                    Sign Up Free
                </a>
                <a href="{{ route('become-tasker') }}" class="btn-cta-outline">
                    <i class="bi bi-briefcase-fill"></i>
                    Become a Tasker
                </a>
            </div>
        </div>
    </div>
</section>
@endsection