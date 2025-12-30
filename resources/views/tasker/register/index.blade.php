@extends('layouts.app')

@section('title', 'Become a Tasker')

@section('content')
<!-- Hero Section -->
<section class="tasker-hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="hero-content">
                    <span class="hero-badge">
                        <i class="bi bi-cash-stack me-2"></i>
                        Start Earning Today
                    </span>
                    <h1 class="hero-title">
                        Become a <span class="text-primary">Tasker</span> and Turn Your Skills Into Income
                    </h1>
                    <p class="hero-subtitle">
                        Join thousands of skilled professionals who are earning on their own terms. 
                        Set your own rates, choose your hours, and work in your area.
                    </p>
                    
                    <div class="hero-stats">
                        <div class="stat-item">
                            <div class="stat-value">$25-85</div>
                            <div class="stat-label">Avg. Hourly Rate</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">10K+</div>
                            <div class="stat-label">Active Taskers</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">4.8★</div>
                            <div class="stat-label">Avg. Rating</div>
                        </div>
                    </div>
                    
                    <form action="{{ route('become-tasker.start') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-lg btn-get-started">
                            <i class="bi bi-rocket-takeoff me-2"></i>
                            Get Started Now
                            <i class="bi bi-arrow-right ms-2"></i>
                        </button>
                    </form>
                    
                    <p class="hero-note">
                        <i class="bi bi-clock me-1"></i>
                        Takes only 10 minutes to complete
                    </p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-image">
                    <div class="image-wrapper">
                        <img src="{{ asset('images/tasker-hero.svg') }}" alt="Become a Tasker" onerror="this.style.display='none'">
                        <div class="floating-card card-1">
                            <i class="bi bi-cash-coin text-success"></i>
                            <span>Instant Payments</span>
                        </div>
                        <div class="floating-card card-2">
                            <i class="bi bi-calendar-check text-primary"></i>
                            <span>Flexible Schedule</span>
                        </div>
                        <div class="floating-card card-3">
                            <i class="bi bi-shield-check text-info"></i>
                            <span>Secure Platform</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- How It Works -->
<section class="how-it-works">
    <div class="container">
        <div class="section-header text-center">
            <span class="section-badge">Simple Process</span>
            <h2 class="section-title">How to Become a Tasker</h2>
            <p class="section-subtitle">Complete these 4 simple steps to start earning</p>
        </div>
        
        <div class="steps-grid">
            <div class="step-card">
                <div class="step-number">1</div>
                <div class="step-icon">
                    <i class="bi bi-person-circle"></i>
                </div>
                <h4>Create Your Profile</h4>
                <p>Tell us about yourself, your skills, and experience. Upload a professional photo.</p>
            </div>
            
            <div class="step-connector">
                <i class="bi bi-arrow-right"></i>
            </div>
            
            <div class="step-card">
                <div class="step-number">2</div>
                <div class="step-icon">
                    <i class="bi bi-grid-3x3-gap"></i>
                </div>
                <h4>Select Services</h4>
                <p>Choose the categories you want to work in and set your hourly rates.</p>
            </div>
            
            <div class="step-connector">
                <i class="bi bi-arrow-right"></i>
            </div>
            
            <div class="step-card">
                <div class="step-number">3</div>
                <div class="step-icon">
                    <i class="bi bi-calendar-week"></i>
                </div>
                <h4>Set Availability</h4>
                <p>Define your weekly schedule. You're in control of when you work.</p>
            </div>
            
            <div class="step-connector">
                <i class="bi bi-arrow-right"></i>
            </div>
            
            <div class="step-card">
                <div class="step-number">4</div>
                <div class="step-icon">
                    <i class="bi bi-patch-check"></i>
                </div>
                <h4>Get Verified</h4>
                <p>Submit your ID for verification. Once approved, you can start accepting tasks!</p>
            </div>
        </div>
    </div>
</section>

<!-- Categories -->
<section class="categories-section">
    <div class="container">
        <div class="section-header text-center">
            <span class="section-badge">Popular Categories</span>
            <h2 class="section-title">What Can You Offer?</h2>
            <p class="section-subtitle">Choose from dozens of service categories</p>
        </div>
        
        <div class="categories-grid">
            <div class="category-card">
                <div class="category-icon" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                    <i class="bi bi-tools"></i>
                </div>
                <h5>Handyman</h5>
                <span class="rate">$35-65/hr</span>
            </div>
            
            <div class="category-card">
                <div class="category-icon" style="background: linear-gradient(135deg, #11998e, #38ef7d);">
                    <i class="bi bi-droplet"></i>
                </div>
                <h5>Cleaning</h5>
                <span class="rate">$25-45/hr</span>
            </div>
            
            <div class="category-card">
                <div class="category-icon" style="background: linear-gradient(135deg, #f5af19, #f12711);">
                    <i class="bi bi-truck"></i>
                </div>
                <h5>Moving</h5>
                <span class="rate">$40-80/hr</span>
            </div>
            
            <div class="category-card">
                <div class="category-icon" style="background: linear-gradient(135deg, #4facfe, #00f2fe);">
                    <i class="bi bi-house-gear"></i>
                </div>
                <h5>Furniture Assembly</h5>
                <span class="rate">$30-55/hr</span>
            </div>
            
            <div class="category-card">
                <div class="category-icon" style="background: linear-gradient(135deg, #f093fb, #f5576c);">
                    <i class="bi bi-lightning-charge"></i>
                </div>
                <h5>Electrical</h5>
                <span class="rate">$45-85/hr</span>
            </div>
            
            <div class="category-card">
                <div class="category-icon" style="background: linear-gradient(135deg, #43e97b, #38f9d7);">
                    <i class="bi bi-brush"></i>
                </div>
                <h5>Painting</h5>
                <span class="rate">$30-60/hr</span>
            </div>
        </div>
    </div>
</section>

<!-- Benefits -->
<section class="benefits-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="section-header">
                    <span class="section-badge">Why Join Us</span>
                    <h2 class="section-title">Benefits of Being a Tasker</h2>
                </div>
                
                <div class="benefits-list">
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="bi bi-wallet2"></i>
                        </div>
                        <div class="benefit-content">
                            <h5>Set Your Own Rates</h5>
                            <p>You decide how much you charge. Keep 85% of every task you complete.</p>
                        </div>
                    </div>
                    
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="bi bi-clock-history"></i>
                        </div>
                        <div class="benefit-content">
                            <h5>Work When You Want</h5>
                            <p>Full flexibility. Accept tasks that fit your schedule, decline what doesn't.</p>
                        </div>
                    </div>
                    
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="bi bi-geo-alt"></i>
                        </div>
                        <div class="benefit-content">
                            <h5>Work In Your Area</h5>
                            <p>Set your service radius. Get matched with tasks near you.</p>
                        </div>
                    </div>
                    
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="bi bi-lightning-charge"></i>
                        </div>
                        <div class="benefit-content">
                            <h5>Fast Payments</h5>
                            <p>Get paid within 24 hours of completing a task. Direct deposit to your bank.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="earnings-card">
                    <h4>Potential Monthly Earnings</h4>
                    <div class="earnings-slider">
                        <div class="earnings-amount">$3,500</div>
                        <p class="earnings-note">Based on 25 hrs/week at $35/hr</p>
                    </div>
                    <div class="earnings-breakdown">
                        <div class="breakdown-item">
                            <span>Part-time (15 hrs/week)</span>
                            <strong>$2,100/mo</strong>
                        </div>
                        <div class="breakdown-item">
                            <span>Full-time (40 hrs/week)</span>
                            <strong>$5,600/mo</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="cta-section">
    <div class="container">
        <div class="cta-card">
            <div class="cta-content">
                <h2>Ready to Start Earning?</h2>
                <p>Join our community of skilled professionals today</p>
                <form action="{{ route('become-tasker.start') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-light btn-lg">
                        <i class="bi bi-rocket-takeoff me-2"></i>
                        Start Your Application
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
/* Hero Section */
.tasker-hero {
    padding: 4rem 0;
    background: linear-gradient(135deg, #fff9f5 0%, #fff 100%);
    overflow: hidden;
}

.hero-badge {
    display: inline-flex;
    align-items: center;
    background: linear-gradient(135deg, #FF6B35, #ff8c5a);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 50px;
    font-size: 0.875rem;
    font-weight: 600;
    margin-bottom: 1.5rem;
}

.hero-title {
    font-size: 3rem;
    font-weight: 700;
    line-height: 1.2;
    margin-bottom: 1.5rem;
    color: #1A1A2E;
}

.hero-title .text-primary {
    color: #FF6B35 !important;
}

.hero-subtitle {
    font-size: 1.125rem;
    color: #6b7280;
    margin-bottom: 2rem;
    line-height: 1.7;
}

.hero-stats {
    display: flex;
    gap: 2rem;
    margin-bottom: 2rem;
}

.stat-item {
    text-align: center;
}

.stat-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1A1A2E;
}

.stat-label {
    font-size: 0.875rem;
    color: #6b7280;
}

.btn-get-started {
    padding: 1rem 2rem;
    font-size: 1.125rem;
    border-radius: 12px;
    background: linear-gradient(135deg, #FF6B35, #e55a2b);
    border: none;
    box-shadow: 0 10px 30px rgba(255, 107, 53, 0.3);
    transition: all 0.3s;
}

.btn-get-started:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 40px rgba(255, 107, 53, 0.4);
}

.hero-note {
    margin-top: 1rem;
    font-size: 0.875rem;
    color: #9ca3af;
}

.hero-image {
    position: relative;
}

.image-wrapper {
    position: relative;
    width: 100%;
    height: 400px;
    background: linear-gradient(135deg, #fff5f0, #ffe8db);
    border-radius: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.image-wrapper img {
    max-width: 80%;
    max-height: 80%;
}

.floating-card {
    position: absolute;
    background: white;
    padding: 0.75rem 1.25rem;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 600;
    font-size: 0.875rem;
    animation: float 3s ease-in-out infinite;
}

.floating-card i {
    font-size: 1.25rem;
}

.card-1 { top: 20%; left: -10%; animation-delay: 0s; }
.card-2 { top: 50%; right: -5%; animation-delay: 1s; }
.card-3 { bottom: 15%; left: 5%; animation-delay: 2s; }

@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

/* Sections */
.section-header {
    margin-bottom: 3rem;
}

.section-badge {
    display: inline-block;
    background: rgba(255, 107, 53, 0.1);
    color: #FF6B35;
    padding: 0.4rem 1rem;
    border-radius: 50px;
    font-size: 0.875rem;
    font-weight: 600;
    margin-bottom: 1rem;
}

.section-title {
    font-size: 2.25rem;
    font-weight: 700;
    color: #1A1A2E;
    margin-bottom: 0.75rem;
}

.section-subtitle {
    font-size: 1.125rem;
    color: #6b7280;
}

/* How It Works */
.how-it-works {
    padding: 5rem 0;
    background: white;
}

.steps-grid {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.step-card {
    background: white;
    border: 2px solid #f3f4f6;
    border-radius: 20px;
    padding: 2rem;
    text-align: center;
    width: 220px;
    position: relative;
    transition: all 0.3s;
}

.step-card:hover {
    border-color: #FF6B35;
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(255, 107, 53, 0.15);
}

.step-number {
    position: absolute;
    top: -15px;
    left: 50%;
    transform: translateX(-50%);
    width: 30px;
    height: 30px;
    background: linear-gradient(135deg, #FF6B35, #e55a2b);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 0.875rem;
}

.step-icon {
    width: 70px;
    height: 70px;
    background: linear-gradient(135deg, #fff5f0, #ffe8db);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.25rem;
    font-size: 1.75rem;
    color: #FF6B35;
}

.step-card h4 {
    font-size: 1.125rem;
    font-weight: 600;
    margin-bottom: 0.75rem;
    color: #1A1A2E;
}

.step-card p {
    font-size: 0.875rem;
    color: #6b7280;
    margin: 0;
    line-height: 1.6;
}

.step-connector {
    color: #d1d5db;
    font-size: 1.5rem;
}

/* Categories */
.categories-section {
    padding: 5rem 0;
    background: #f9fafb;
}

.categories-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
    gap: 1.5rem;
    max-width: 900px;
    margin: 0 auto;
}

.category-card {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    text-align: center;
    transition: all 0.3s;
    border: 2px solid transparent;
}

.category-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.1);
    border-color: #FF6B35;
}

.category-icon {
    width: 60px;
    height: 60px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    color: white;
    font-size: 1.5rem;
}

.category-card h5 {
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: #1A1A2E;
}

.category-card .rate {
    font-size: 0.875rem;
    color: #10b981;
    font-weight: 600;
}

/* Benefits */
.benefits-section {
    padding: 5rem 0;
    background: white;
}

.benefits-list {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.benefit-item {
    display: flex;
    gap: 1.25rem;
    align-items: flex-start;
}

.benefit-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #FF6B35, #ff8c5a);
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.25rem;
    flex-shrink: 0;
}

.benefit-content h5 {
    font-size: 1.125rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
    color: #1A1A2E;
}

.benefit-content p {
    font-size: 0.9rem;
    color: #6b7280;
    margin: 0;
}

.earnings-card {
    background: linear-gradient(135deg, #1A1A2E, #2d2d44);
    border-radius: 24px;
    padding: 2.5rem;
    color: white;
    text-align: center;
}

.earnings-card h4 {
    font-size: 1.25rem;
    margin-bottom: 1.5rem;
    opacity: 0.9;
}

.earnings-amount {
    font-size: 3.5rem;
    font-weight: 700;
    color: #FF6B35;
    margin-bottom: 0.5rem;
}

.earnings-note {
    font-size: 0.875rem;
    opacity: 0.7;
    margin-bottom: 2rem;
}

.earnings-breakdown {
    border-top: 1px solid rgba(255,255,255,0.1);
    padding-top: 1.5rem;
}

.breakdown-item {
    display: flex;
    justify-content: space-between;
    padding: 0.75rem 0;
    border-bottom: 1px solid rgba(255,255,255,0.05);
}

.breakdown-item span {
    opacity: 0.7;
}

.breakdown-item strong {
    color: #10b981;
}

/* CTA */
.cta-section {
    padding: 5rem 0;
    background: #f9fafb;
}

.cta-card {
    background: linear-gradient(135deg, #FF6B35, #e55a2b);
    border-radius: 24px;
    padding: 4rem;
    text-align: center;
    color: white;
}

.cta-card h2 {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 0.75rem;
}

.cta-card p {
    font-size: 1.25rem;
    opacity: 0.9;
    margin-bottom: 2rem;
}

.cta-card .btn-light {
    background: white;
    color: #FF6B35;
    padding: 1rem 2rem;
    font-size: 1.125rem;
    font-weight: 600;
    border-radius: 12px;
    border: none;
}

.cta-card .btn-light:hover {
    background: #f9fafb;
    transform: translateY(-2px);
}

/* Responsive */
@media (max-width: 991.98px) {
    .hero-title {
        font-size: 2.25rem;
    }
    
    .hero-image {
        margin-top: 3rem;
    }
    
    .step-connector {
        display: none;
    }
    
    .steps-grid {
        gap: 2rem;
    }
}

@media (max-width: 767.98px) {
    .hero-stats {
        flex-wrap: wrap;
        gap: 1.5rem;
    }
    
    .stat-item {
        flex: 1 1 80px;
    }
    
    .floating-card {
        display: none;
    }
}
</style>
@endpush