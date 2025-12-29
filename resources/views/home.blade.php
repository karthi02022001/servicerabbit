@extends('layouts.app')

@section('title', 'Service Rabbit - Get Help from Trusted Local Taskers')

@push('styles')
<style>
/* ========================================
   PREMIUM HOME PAGE STYLES - FIXED
   ======================================== */

/* Hero Section - Banner Image Style */
.hero-banner {
    min-height: 600px;
    background: url('https://images.unsplash.com/photo-1581578731548-c64695cc6952?auto=format&fit=crop&w=1920&q=80') center center;
    background-size: cover;
    background-attachment: fixed;
    position: relative;
    display: flex;
    align-items: center;
    padding: 140px 0 80px;
}

.hero-banner::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(15, 12, 41, 0.93) 0%, rgba(48, 43, 99, 0.9) 50%, rgba(36, 36, 62, 0.92) 100%);
    z-index: 1;
}

.hero-content-wrapper {
    position: relative;
    z-index: 10;
}

/* Hero Title */
.hero-banner-title {
    font-size: 3.5rem;
    font-weight: 800;
    color: white;
    line-height: 1.15;
    margin-bottom: 1.5rem;
    letter-spacing: -1px;
    text-shadow: 0 4px 30px rgba(0, 0, 0, 0.3);
}

.hero-banner-title .highlight {
    color: #FF6B35;
    position: relative;
}

.hero-banner-title .highlight::after {
    content: '';
    position: absolute;
    bottom: 5px;
    left: 0;
    width: 100%;
    height: 12px;
    background: rgba(255, 107, 53, 0.3);
    z-index: -1;
    border-radius: 4px;
}

.hero-banner-subtitle {
    font-size: 1.2rem;
    color: rgba(255, 255, 255, 0.85);
    margin-bottom: 2.5rem;
    max-width: 600px;
    line-height: 1.8;
    font-weight: 400;
}

/* Search Box - Clean White Style */
.search-box-hero {
    background: white;
    border-radius: 16px;
    padding: 8px;
    max-width: 700px;
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.3);
}

.search-box-inner {
    display: flex;
    align-items: center;
    gap: 0;
}

.search-input-wrapper {
    flex: 1;
    display: flex;
    align-items: center;
    padding: 14px 20px;
    border-right: 2px solid #f3f4f6;
}

.search-input-wrapper:last-of-type {
    border-right: none;
}

.search-input-wrapper i {
    color: #9ca3af;
    font-size: 1.25rem;
    margin-right: 12px;
}

.search-input-wrapper input {
    border: none;
    background: transparent;
    color: #1f2937;
    font-size: 1rem;
    width: 100%;
    outline: none;
    font-family: 'Poppins', sans-serif;
}

.search-input-wrapper input::placeholder {
    color: #9ca3af;
}

.search-btn-hero {
    background: linear-gradient(135deg, #FF6B35 0%, #ff8c5a 100%);
    color: white;
    border: none;
    padding: 16px 32px;
    border-radius: 12px;
    font-weight: 600;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
    font-family: 'Poppins', sans-serif;
    white-space: nowrap;
    margin: 4px;
}

.search-btn-hero:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(255, 107, 53, 0.4);
}

/* Popular Services Tags */
.popular-services {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 10px;
    margin-top: 2rem;
}

.popular-services-label {
    color: rgba(255, 255, 255, 0.6);
    font-size: 0.9rem;
    font-weight: 500;
    margin-right: 5px;
}

.service-tag {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    background: transparent;
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 50px;
    color: rgba(255, 255, 255, 0.9);
    font-size: 0.85rem;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.3s ease;
}

.service-tag:hover {
    background: #FF6B35;
    border-color: #FF6B35;
    color: white;
    transform: translateY(-2px);
}

.service-tag i {
    font-size: 0.9rem;
}

/* Hero Stats Row */
.hero-stats {
    display: flex;
    gap: 50px;
    margin-top: 2.5rem;
    padding-top: 2rem;
    border-top: 1px solid rgba(255, 255, 255, 0.15);
}

.hero-stat-item {
    text-align: left;
}

.hero-stat-value {
    font-size: 2.2rem;
    font-weight: 800;
    color: white;
    line-height: 1;
    margin-bottom: 8px;
}

.hero-stat-value span {
    color: #FF6B35;
}

.hero-stat-label {
    color: rgba(255, 255, 255, 0.7);
    font-size: 0.9rem;
    font-weight: 400;
}

/* ========================================
   SERVICES SECTION - PREMIUM
   ======================================== */
.services-premium {
    padding: 100px 0 80px;
    background: white;
}

.section-header-premium {
    text-align: center;
    margin-bottom: 60px;
}

.section-label {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: linear-gradient(135deg, rgba(255, 107, 53, 0.1), rgba(255, 140, 90, 0.05));
    color: #FF6B35;
    padding: 10px 24px;
    border-radius: 50px;
    font-size: 0.85rem;
    font-weight: 600;
    margin-bottom: 20px;
    border: 1px solid rgba(255, 107, 53, 0.2);
}

.section-title-premium {
    font-size: 2.75rem;
    font-weight: 800;
    color: #1f2937;
    margin-bottom: 16px;
    letter-spacing: -1px;
}

.section-desc-premium {
    font-size: 1.1rem;
    color: #6b7280;
    max-width: 600px;
    margin: 0 auto;
    line-height: 1.7;
}

/* Service Card Premium */
.service-card-premium {
    background: white;
    border-radius: 24px;
    padding: 35px 25px;
    text-align: center;
    position: relative;
    overflow: hidden;
    border: 2px solid #f3f4f6;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    text-decoration: none;
    display: block;
    height: 100%;
}

.service-card-premium::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #FF6B35, #ffd700);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.service-card-premium:hover {
    transform: translateY(-12px);
    border-color: #FF6B35;
    box-shadow: 0 25px 50px rgba(255, 107, 53, 0.15);
}

.service-card-premium:hover::before {
    opacity: 1;
}

.service-icon-premium {
    width: 80px;
    height: 80px;
    margin: 0 auto 20px;
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    transition: all 0.4s ease;
}

.service-card-premium:hover .service-icon-premium {
    transform: scale(1.1) rotate(5deg);
}

/* Service Icon Colors */
.service-icon-premium.cleaning { background: linear-gradient(135deg, #dbeafe, #bfdbfe); color: #2563eb; }
.service-icon-premium.handyman { background: linear-gradient(135deg, #fef3c7, #fde68a); color: #d97706; }
.service-icon-premium.moving { background: linear-gradient(135deg, #d1fae5, #a7f3d0); color: #059669; }
.service-icon-premium.delivery { background: linear-gradient(135deg, #ede9fe, #ddd6fe); color: #7c3aed; }
.service-icon-premium.assembly { background: linear-gradient(135deg, #fce7f3, #fbcfe8); color: #db2777; }
.service-icon-premium.painting { background: linear-gradient(135deg, #ffedd5, #fed7aa); color: #ea580c; }
.service-icon-premium.plumbing { background: linear-gradient(135deg, #cffafe, #a5f3fc); color: #0891b2; }
.service-icon-premium.electrical { background: linear-gradient(135deg, #fef9c3, #fef08a); color: #ca8a04; }

.service-card-premium h5 {
    font-size: 1.15rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 8px;
}

.service-card-premium p {
    color: #6b7280;
    font-size: 0.9rem;
    margin-bottom: 16px;
    line-height: 1.5;
}

.service-meta {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 16px;
    padding-top: 16px;
    border-top: 1px solid #f3f4f6;
}

.service-meta-item {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 0.8rem;
    color: #6b7280;
}

.service-meta-item i {
    color: #FF6B35;
}

.service-meta-item.price {
    font-weight: 700;
    color: #FF6B35;
    font-size: 1rem;
}

/* ========================================
   HOW IT WORKS - FIXED CARD LAYOUT
   ======================================== */
.how-it-works-section {
    padding: 100px 0;
    background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);
}

.step-card-premium {
    background: white;
    border-radius: 24px;
    padding: 40px 30px;
    text-align: center;
    position: relative;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
    height: 100%;
    border: 1px solid #f3f4f6;
}

.step-card-premium:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.1);
}

.step-number-badge {
    position: absolute;
    top: -20px;
    left: 50%;
    transform: translateX(-50%);
    width: 45px;
    height: 45px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    font-weight: 800;
    color: white;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
}

.step-number-badge.step-1 { background: linear-gradient(135deg, #FF6B35, #ff8c5a); }
.step-number-badge.step-2 { background: linear-gradient(135deg, #667eea, #764ba2); }
.step-number-badge.step-3 { background: linear-gradient(135deg, #10b981, #34d399); }
.step-number-badge.step-4 { background: linear-gradient(135deg, #f59e0b, #fbbf24); }

.step-icon-box {
    width: 80px;
    height: 80px;
    margin: 20px auto 25px;
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
}

.step-icon-box.icon-1 { background: #fff1ed; color: #FF6B35; }
.step-icon-box.icon-2 { background: #eef2ff; color: #667eea; }
.step-icon-box.icon-3 { background: #ecfdf5; color: #10b981; }
.step-icon-box.icon-4 { background: #fffbeb; color: #f59e0b; }

.step-card-premium h4 {
    font-size: 1.3rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 12px;
}

.step-card-premium p {
    color: #6b7280;
    font-size: 0.95rem;
    line-height: 1.6;
    margin: 0;
}

/* Step Connector Line */
.step-connector {
    display: flex;
    align-items: center;
    justify-content: center;
    padding-top: 40px;
}

.connector-line {
    width: 60px;
    height: 3px;
    background: linear-gradient(90deg, #e5e7eb, #FF6B35);
    border-radius: 3px;
}

/* ========================================
   FEATURED TASKERS - PREMIUM
   ======================================== */
.taskers-premium {
    padding: 100px 0;
    background: white;
}

.tasker-card-premium {
    background: white;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.06);
    transition: all 0.4s ease;
    border: 1px solid #f3f4f6;
}

.tasker-card-premium:hover {
    transform: translateY(-12px);
    box-shadow: 0 30px 60px rgba(0, 0, 0, 0.12);
}

.tasker-card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 30px 20px 45px;
    text-align: center;
    position: relative;
}

.tasker-verified-badge {
    position: absolute;
    top: 12px;
    right: 12px;
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    padding: 5px 12px;
    border-radius: 50px;
    color: white;
    font-size: 0.7rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 4px;
}

.tasker-avatar-premium {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    border: 4px solid white;
    background: white;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    font-size: 2rem;
    font-weight: 700;
    color: #667eea;
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
    overflow: hidden;
}

.tasker-avatar-premium img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.tasker-card-body {
    padding: 25px 20px;
    text-align: center;
    margin-top: -25px;
    background: white;
    border-radius: 24px 24px 0 0;
    position: relative;
}

.tasker-name-premium {
    font-size: 1.2rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 4px;
}

.tasker-headline {
    color: #6b7280;
    font-size: 0.85rem;
    margin-bottom: 12px;
}

.tasker-rating-premium {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #fef3c7;
    padding: 6px 14px;
    border-radius: 50px;
    margin-bottom: 16px;
}

.tasker-rating-premium .stars {
    color: #f59e0b;
    font-size: 0.8rem;
}

.tasker-rating-premium .rating-value {
    font-weight: 700;
    color: #1f2937;
    font-size: 0.9rem;
}

.tasker-rating-premium .review-count {
    color: #6b7280;
    font-size: 0.8rem;
}

.tasker-stats-premium {
    display: flex;
    justify-content: center;
    gap: 25px;
    padding: 16px 0;
    border-top: 1px solid #f3f4f6;
    border-bottom: 1px solid #f3f4f6;
    margin-bottom: 16px;
}

.tasker-stat-item {
    text-align: center;
}

.tasker-stat-item .value {
    font-size: 1.2rem;
    font-weight: 700;
    color: #1f2937;
}

.tasker-stat-item .label {
    font-size: 0.7rem;
    color: #9ca3af;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.tasker-price-premium {
    font-size: 1.6rem;
    font-weight: 700;
    color: #FF6B35;
    margin-bottom: 16px;
}

.tasker-price-premium span {
    font-size: 0.9rem;
    color: #9ca3af;
    font-weight: 400;
}

.btn-book-tasker {
    width: 100%;
    padding: 12px 20px;
    background: linear-gradient(135deg, #FF6B35, #ff8c5a);
    color: white;
    border: none;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    text-decoration: none;
}

.btn-book-tasker:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(255, 107, 53, 0.3);
    color: white;
}

/* ========================================
   STATS SECTION - PREMIUM
   ======================================== */
.stats-premium {
    padding: 80px 0;
    background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
    position: relative;
    overflow: hidden;
}

.stats-premium::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: 
        radial-gradient(circle at 10% 20%, rgba(255, 107, 53, 0.1) 0%, transparent 40%),
        radial-gradient(circle at 90% 80%, rgba(102, 126, 234, 0.1) 0%, transparent 40%);
}

.stat-card-premium {
    text-align: center;
    padding: 30px 15px;
    position: relative;
    z-index: 1;
}

.stat-icon-premium {
    width: 70px;
    height: 70px;
    margin: 0 auto 20px;
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
}

.stat-icon-premium.icon-1 { background: linear-gradient(135deg, #FF6B35, #ff8c5a); color: white; }
.stat-icon-premium.icon-2 { background: linear-gradient(135deg, #667eea, #764ba2); color: white; }
.stat-icon-premium.icon-3 { background: linear-gradient(135deg, #10b981, #34d399); color: white; }
.stat-icon-premium.icon-4 { background: linear-gradient(135deg, #f59e0b, #fbbf24); color: white; }

.stat-value-premium {
    font-size: 3rem;
    font-weight: 800;
    color: white;
    line-height: 1;
    margin-bottom: 8px;
}

.stat-label-premium {
    color: rgba(255, 255, 255, 0.6);
    font-size: 0.95rem;
    font-weight: 500;
}

/* ========================================
   TESTIMONIALS - PREMIUM
   ======================================== */
.testimonials-premium {
    padding: 100px 0;
    background: #f8fafc;
}

.testimonial-card-premium {
    background: white;
    border-radius: 24px;
    padding: 35px;
    height: 100%;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.04);
    transition: all 0.3s ease;
    border: 1px solid #f3f4f6;
}

.testimonial-card-premium:hover {
    transform: translateY(-8px);
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.1);
}

.testimonial-quote-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #FF6B35, #ff8c5a);
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    color: white;
    margin-bottom: 20px;
}

.testimonial-text-premium {
    font-size: 1.05rem;
    color: #4b5563;
    line-height: 1.8;
    margin-bottom: 25px;
    font-style: italic;
}

.testimonial-author-premium {
    display: flex;
    align-items: center;
    gap: 14px;
}

.testimonial-avatar-premium {
    width: 55px;
    height: 55px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea, #764ba2);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 1.1rem;
}

.testimonial-info h6 {
    font-weight: 700;
    color: #1f2937;
    margin: 0 0 3px;
    font-size: 1rem;
}

.testimonial-info p {
    color: #6b7280;
    font-size: 0.8rem;
    margin: 0 0 4px;
}

.testimonial-rating-premium {
    color: #fbbf24;
    font-size: 0.8rem;
}

/* ========================================
   CTA SECTION - PREMIUM
   ======================================== */
.cta-premium {
    padding: 100px 0;
    background: linear-gradient(135deg, #FF6B35 0%, #ff8c5a 50%, #ffd700 100%);
    position: relative;
    overflow: hidden;
}

.cta-premium::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 500px;
    height: 500px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
}

.cta-premium::after {
    content: '';
    position: absolute;
    bottom: -30%;
    left: -10%;
    width: 350px;
    height: 350px;
    background: rgba(255, 255, 255, 0.08);
    border-radius: 50%;
}

.cta-content-premium {
    position: relative;
    z-index: 1;
    text-align: center;
}

.cta-title-premium {
    font-size: 3rem;
    font-weight: 800;
    color: white;
    margin-bottom: 16px;
    letter-spacing: -1px;
}

.cta-subtitle-premium {
    font-size: 1.2rem;
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 35px;
    max-width: 550px;
    margin-left: auto;
    margin-right: auto;
}

.cta-buttons-premium {
    display: flex;
    justify-content: center;
    gap: 16px;
    flex-wrap: wrap;
}

.btn-cta-white {
    background: white;
    color: #FF6B35;
    padding: 16px 36px;
    border-radius: 14px;
    font-weight: 700;
    font-size: 1rem;
    text-decoration: none;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
}

.btn-cta-white:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 45px rgba(0, 0, 0, 0.2);
    color: #FF6B35;
}

.btn-cta-outline {
    background: transparent;
    color: white;
    padding: 16px 36px;
    border-radius: 14px;
    font-weight: 700;
    font-size: 1rem;
    text-decoration: none;
    transition: all 0.3s ease;
    border: 2px solid rgba(255, 255, 255, 0.5);
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-cta-outline:hover {
    background: rgba(255, 255, 255, 0.1);
    border-color: white;
    color: white;
}

/* ========================================
   RESPONSIVE STYLES
   ======================================== */
@media (max-width: 1199.98px) {
    .hero-banner-title {
        font-size: 3rem;
    }
    
    .hero-stats {
        gap: 30px;
    }
}

@media (max-width: 991.98px) {
    .hero-banner {
        min-height: auto;
        padding: 120px 0 60px;
        background-attachment: scroll;
    }
    
    .hero-banner-title {
        font-size: 2.5rem;
    }
    
    .search-box-inner {
        flex-direction: column;
    }
    
    .search-input-wrapper {
        width: 100%;
        border-right: none;
        border-bottom: 2px solid #f3f4f6;
    }
    
    .search-input-wrapper:last-of-type {
        border-bottom: none;
    }
    
    .search-btn-hero {
        width: 100%;
        justify-content: center;
    }
    
    .hero-stats {
        gap: 30px;
    }
    
    .hero-stat-value {
        font-size: 1.8rem;
    }
    
    .section-title-premium {
        font-size: 2rem;
    }
    
    .cta-title-premium {
        font-size: 2.2rem;
    }
    
    .step-connector {
        display: none;
    }
}

@media (max-width: 767.98px) {
    .hero-banner {
        padding: 100px 0 50px;
    }
    
    .hero-banner-title {
        font-size: 1.9rem;
        letter-spacing: -0.5px;
    }
    
    .hero-banner-title .highlight::after {
        height: 8px;
        bottom: 2px;
    }
    
    .hero-banner-subtitle {
        font-size: 1rem;
    }
    
    .popular-services {
        justify-content: flex-start;
    }
    
    .hero-stats {
        gap: 20px;
        margin-top: 2rem;
        padding-top: 1.5rem;
    }
    
    .hero-stat-value {
        font-size: 1.5rem;
    }
    
    .hero-stat-label {
        font-size: 0.8rem;
    }
    
    .section-title-premium {
        font-size: 1.75rem;
    }
    
    .stat-value-premium {
        font-size: 2.2rem;
    }
    
    .cta-title-premium {
        font-size: 1.8rem;
    }
    
    .cta-buttons-premium {
        flex-direction: column;
        align-items: center;
    }
    
    .btn-cta-white,
    .btn-cta-outline {
        width: 100%;
        max-width: 280px;
        justify-content: center;
    }
    
    .step-card-premium {
        margin-bottom: 40px;
    }
}

@media (max-width: 575.98px) {
    .hero-banner-title {
        font-size: 1.65rem;
    }
    
    .service-tag {
        padding: 6px 12px;
        font-size: 0.8rem;
    }
    
    .hero-stats {
        flex-wrap: wrap;
        gap: 15px;
    }
    
    .hero-stat-item {
        flex: 0 0 45%;
    }
    
    .hero-stat-value {
        font-size: 1.35rem;
    }
    
    .hero-stat-label {
        font-size: 0.75rem;
    }
}
</style>
@endpush

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

<!-- How It Works - FIXED Card Layout -->
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
@if(($taskers ?? collect([]))->isNotEmpty())
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
                    <div class="stat-value-premium">{{ number_format($stats['total_users'] ?? 10000) }}+</div>
                    <div class="stat-label-premium">Happy Customers</div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="stat-card-premium">
                    <div class="stat-icon-premium icon-2">
                        <i class="bi bi-person-badge-fill"></i>
                    </div>
                    <div class="stat-value-premium">{{ number_format($stats['total_taskers'] ?? 500) }}+</div>
                    <div class="stat-label-premium">Verified Taskers</div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="stat-card-premium">
                    <div class="stat-icon-premium icon-3">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <div class="stat-value-premium">{{ number_format($stats['total_bookings'] ?? 25000) }}+</div>
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