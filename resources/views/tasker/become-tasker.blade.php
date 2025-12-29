@extends('layouts.app')

@section('title', 'Become a Tasker')

@section('content')
<!-- Hero Section -->
<section class="hero-section py-5">
    <div class="container">
        <div class="row align-items-center min-vh-75">
            <div class="col-lg-6">
                <span class="badge bg-warning text-dark mb-3 px-3 py-2">
                    <i class="bi bi-star-fill me-1"></i> Join Our Community
                </span>
                <h1 class="display-4 fw-bold text-white mb-4">
                    Earn Money on <span class="text-warning">Your Schedule</span>
                </h1>
                <p class="lead text-white-50 mb-4">
                    Join thousands of skilled Taskers who are earning money while helping others in their community. 
                    Set your own rates, choose your own tasks, and work when you want.
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    @auth
                        @if(auth()->user()->is_tasker)
                            <a href="{{ route('tasker.dashboard') }}" class="btn btn-primary btn-lg">
                                <i class="bi bi-speedometer2 me-2"></i> Go to Tasker Dashboard
                            </a>
                        @else
                            <a href="{{ route('tasker.register.step1') }}" class="btn btn-primary btn-lg">
                                <i class="bi bi-arrow-right me-2"></i> Start Registration
                            </a>
                        @endif
                    @else
                        <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
                            <i class="bi bi-person-plus me-2"></i> Sign Up to Get Started
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg">
                            Already have an account?
                        </a>
                    @endauth
                </div>
            </div>
            <div class="col-lg-6 d-none d-lg-block">
                <div class="position-relative">
                    <img src="{{ asset('images/tasker-hero.svg') }}" alt="Become a Tasker" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="row text-center g-4">
            <div class="col-6 col-md-3">
                <div class="stat-item">
                    <h2 class="display-5 fw-bold text-primary mb-0">$35+</h2>
                    <p class="text-muted mb-0">Average Hourly Rate</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-item">
                    <h2 class="display-5 fw-bold text-primary mb-0">100K+</h2>
                    <p class="text-muted mb-0">Active Taskers</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-item">
                    <h2 class="display-5 fw-bold text-primary mb-0">2M+</h2>
                    <p class="text-muted mb-0">Tasks Completed</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-item">
                    <h2 class="display-5 fw-bold text-primary mb-0">$50M+</h2>
                    <p class="text-muted mb-0">Paid to Taskers</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">How It Works</h2>
            <p class="text-muted">Start earning in just a few simple steps</p>
        </div>
        <div class="row g-4">
            <div class="col-md-3">
                <div class="text-center">
                    <div class="step-icon bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="bi bi-person-plus fs-2"></i>
                    </div>
                    <h5 class="fw-semibold">1. Create Your Profile</h5>
                    <p class="text-muted small">Sign up and build your professional profile with your skills and experience.</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="text-center">
                    <div class="step-icon bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="bi bi-card-checklist fs-2"></i>
                    </div>
                    <h5 class="fw-semibold">2. Get Verified</h5>
                    <p class="text-muted small">Complete ID verification to build trust with customers.</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="text-center">
                    <div class="step-icon bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="bi bi-calendar-check fs-2"></i>
                    </div>
                    <h5 class="fw-semibold">3. Set Availability</h5>
                    <p class="text-muted small">Choose when you want to work. You're in complete control.</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="text-center">
                    <div class="step-icon bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="bi bi-cash-coin fs-2"></i>
                    </div>
                    <h5 class="fw-semibold">4. Start Earning</h5>
                    <p class="text-muted small">Accept tasks and get paid securely through our platform.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Popular Task Categories</h2>
            <p class="text-muted">Choose from a variety of services you can offer</p>
        </div>
        <div class="row g-4">
            @php
                $taskCategories = [
                    ['icon' => 'bi-box-seam', 'name' => 'Packing & Moving', 'rate' => '$45-80/hr'],
                    ['icon' => 'bi-tools', 'name' => 'Furniture Assembly', 'rate' => '$25-60/hr'],
                    ['icon' => 'bi-house', 'name' => 'Cleaning', 'rate' => '$25-50/hr'],
                    ['icon' => 'bi-wrench', 'name' => 'Handyman', 'rate' => '$30-70/hr'],
                    ['icon' => 'bi-truck', 'name' => 'Delivery', 'rate' => '$20-40/hr'],
                    ['icon' => 'bi-droplet', 'name' => 'Plumbing', 'rate' => '$40-90/hr'],
                    ['icon' => 'bi-cart', 'name' => 'Errands', 'rate' => '$20-35/hr'],
                    ['icon' => 'bi-heart', 'name' => 'Pet Sitting', 'rate' => '$20-45/hr'],
                ];
            @endphp
            @foreach($taskCategories as $category)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="category-card bg-white rounded-4 p-4 shadow-sm h-100 text-center">
                        <div class="icon-wrapper bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="{{ $category['icon'] }} fs-4"></i>
                        </div>
                        <h6 class="fw-semibold mb-1">{{ $category['name'] }}</h6>
                        <small class="text-success fw-medium">{{ $category['rate'] }}</small>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Benefits Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <img src="{{ asset('images/benefits-illustration.svg') }}" alt="Benefits" class="img-fluid rounded-4">
            </div>
            <div class="col-lg-6">
                <h2 class="fw-bold mb-4">Why Become a Tasker?</h2>
                
                <div class="benefit-item d-flex mb-4">
                    <div class="benefit-icon bg-success text-white rounded-3 d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 50px; height: 50px;">
                        <i class="bi bi-clock fs-5"></i>
                    </div>
                    <div>
                        <h5 class="fw-semibold mb-1">Flexible Schedule</h5>
                        <p class="text-muted mb-0">Work when you want. Set your own hours and take time off whenever you need.</p>
                    </div>
                </div>
                
                <div class="benefit-item d-flex mb-4">
                    <div class="benefit-icon bg-primary text-white rounded-3 d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 50px; height: 50px;">
                        <i class="bi bi-currency-dollar fs-5"></i>
                    </div>
                    <div>
                        <h5 class="fw-semibold mb-1">Set Your Own Rates</h5>
                        <p class="text-muted mb-0">You decide how much to charge. Earn more for specialized skills.</p>
                    </div>
                </div>
                
                <div class="benefit-item d-flex mb-4">
                    <div class="benefit-icon bg-warning text-dark rounded-3 d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 50px; height: 50px;">
                        <i class="bi bi-shield-check fs-5"></i>
                    </div>
                    <div>
                        <h5 class="fw-semibold mb-1">Secure Payments</h5>
                        <p class="text-muted mb-0">Get paid directly to your bank account. No chasing clients for payment.</p>
                    </div>
                </div>
                
                <div class="benefit-item d-flex mb-4">
                    <div class="benefit-icon bg-info text-white rounded-3 d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 50px; height: 50px;">
                        <i class="bi bi-geo-alt fs-5"></i>
                    </div>
                    <div>
                        <h5 class="fw-semibold mb-1">Work Near Home</h5>
                        <p class="text-muted mb-0">Set your work area and only get tasks in locations convenient for you.</p>
                    </div>
                </div>
                
                <div class="benefit-item d-flex">
                    <div class="benefit-icon bg-danger text-white rounded-3 d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 50px; height: 50px;">
                        <i class="bi bi-headset fs-5"></i>
                    </div>
                    <div>
                        <h5 class="fw-semibold mb-1">24/7 Support</h5>
                        <p class="text-muted mb-0">Our dedicated support team is always available to help you succeed.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Requirements Section -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Requirements to Join</h2>
            <p class="text-muted">Here's what you need to get started</p>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="requirement-card bg-white rounded-4 p-4 shadow-sm h-100">
                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-check-circle-fill text-success fs-4 me-2"></i>
                                <h6 class="fw-semibold mb-0">Be 18 or Older</h6>
                            </div>
                            <p class="text-muted small mb-0">You must be at least 18 years old to register as a Tasker.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="requirement-card bg-white rounded-4 p-4 shadow-sm h-100">
                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-check-circle-fill text-success fs-4 me-2"></i>
                                <h6 class="fw-semibold mb-0">Valid ID</h6>
                            </div>
                            <p class="text-muted small mb-0">Provide a valid government-issued ID for verification.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="requirement-card bg-white rounded-4 p-4 shadow-sm h-100">
                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-check-circle-fill text-success fs-4 me-2"></i>
                                <h6 class="fw-semibold mb-0">Smartphone</h6>
                            </div>
                            <p class="text-muted small mb-0">Access to a smartphone for managing tasks and communication.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="requirement-card bg-white rounded-4 p-4 shadow-sm h-100">
                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-check-circle-fill text-success fs-4 me-2"></i>
                                <h6 class="fw-semibold mb-0">Bank Account</h6>
                            </div>
                            <p class="text-muted small mb-0">A bank account for receiving secure payments.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Hear from Our Taskers</h2>
            <p class="text-muted">Real stories from real Taskers</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="testimonial-card bg-white rounded-4 p-4 shadow-sm h-100">
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                            <span class="fw-bold">MJ</span>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-semibold">Michael J.</h6>
                            <small class="text-muted">Handyman • 2 years</small>
                        </div>
                    </div>
                    <div class="text-warning mb-2">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <p class="text-muted mb-0">"Service Rabbit has been a game-changer for me. I left my 9-5 and now make more money doing what I love with complete flexibility."</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="testimonial-card bg-white rounded-4 p-4 shadow-sm h-100">
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                            <span class="fw-bold">SL</span>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-semibold">Sarah L.</h6>
                            <small class="text-muted">Cleaning • 1 year</small>
                        </div>
                    </div>
                    <div class="text-warning mb-2">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <p class="text-muted mb-0">"As a single mom, the flexible hours are perfect. I can work while my kids are at school and still be there for them."</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="testimonial-card bg-white rounded-4 p-4 shadow-sm h-100">
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                            <span class="fw-bold">DK</span>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-semibold">David K.</h6>
                            <small class="text-muted">Moving • 3 years</small>
                        </div>
                    </div>
                    <div class="text-warning mb-2">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-half"></i>
                    </div>
                    <p class="text-muted mb-0">"Started as a side gig, now it's my main income. The platform is easy to use and the support team is always helpful."</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Frequently Asked Questions</h2>
            <p class="text-muted">Got questions? We've got answers</p>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item border-0 mb-3 shadow-sm rounded-4 overflow-hidden">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                How much can I earn as a Tasker?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted">
                                Earnings vary based on your skills, location, and availability. On average, Taskers earn $25-50 per hour, with specialized skills earning more. You set your own rates and keep 85-95% of what you earn depending on the service category.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item border-0 mb-3 shadow-sm rounded-4 overflow-hidden">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                How do I get paid?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted">
                                Payments are processed securely through Stripe. After completing a task, funds are released to your wallet and you can transfer to your bank account anytime. Most transfers complete within 2-3 business days.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item border-0 mb-3 shadow-sm rounded-4 overflow-hidden">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                Is there a cost to join?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted">
                                No, it's completely free to join and create your Tasker profile. We only take a small commission when you complete tasks - typically 5-15% depending on the service category.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item border-0 mb-3 shadow-sm rounded-4 overflow-hidden">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                What if a customer cancels?
                            </button>
                        </h2>
                        <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted">
                                If a customer cancels within 24 hours of the scheduled task, they may be charged a cancellation fee, a portion of which goes to you for your time. Our policies protect Taskers from last-minute cancellations.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item border-0 shadow-sm rounded-4 overflow-hidden">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                                Am I covered by insurance?
                            </button>
                        </h2>
                        <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted">
                                Yes! All Taskers are covered by our liability protection while performing tasks. We provide up to $1 million in coverage for eligible tasks. Additional insurance options are available for certain service categories.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5 bg-primary text-white">
    <div class="container text-center">
        <h2 class="fw-bold mb-3">Ready to Start Earning?</h2>
        <p class="lead mb-4 opacity-75">Join our community of trusted Taskers today</p>
        @auth
            @if(!auth()->user()->is_tasker)
                <a href="{{ route('tasker.register.step1') }}" class="btn btn-light btn-lg px-5">
                    <i class="bi bi-arrow-right me-2"></i> Start Your Application
                </a>
            @else
                <a href="{{ route('tasker.dashboard') }}" class="btn btn-light btn-lg px-5">
                    <i class="bi bi-speedometer2 me-2"></i> Go to Dashboard
                </a>
            @endif
        @else
            <a href="{{ route('register') }}" class="btn btn-light btn-lg px-5">
                <i class="bi bi-person-plus me-2"></i> Sign Up Now
            </a>
        @endauth
    </div>
</section>
@endsection