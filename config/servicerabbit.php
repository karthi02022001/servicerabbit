<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Commission Settings
    |--------------------------------------------------------------------------
    */

    'commission' => [
        'default_percentage' => env('DEFAULT_COMMISSION_PERCENTAGE', 10),
    ],

    /*
    |--------------------------------------------------------------------------
    | Booking Settings
    |--------------------------------------------------------------------------
    */

    'booking' => [
        'min_hours' => env('MIN_BOOKING_HOURS', 1),
        'max_hours' => env('MAX_BOOKING_HOURS', 8),
        'cancellation_deadline_hours' => env('CANCELLATION_DEADLINE_HOURS', 24),
        'auto_complete_hours' => env('AUTO_COMPLETE_HOURS', 48),
    ],

    /*
    |--------------------------------------------------------------------------
    | Tasker Settings
    |--------------------------------------------------------------------------
    */

    'tasker' => [
        'auto_approval' => env('TASKER_AUTO_APPROVAL', false),
        'require_id_verification' => env('REQUIRE_ID_VERIFICATION', true),
        'require_background_check' => env('REQUIRE_BACKGROUND_CHECK', false),
        'min_payout_amount' => env('MIN_PAYOUT_AMOUNT', 50),
        'default_work_radius_km' => 50,
    ],

    /*
    |--------------------------------------------------------------------------
    | Payment Settings
    |--------------------------------------------------------------------------
    */

    'payment' => [
        'currency' => 'USD',
        'currency_symbol' => '$',
        'stripe_mode' => env('STRIPE_MODE', 'test'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Review Settings
    |--------------------------------------------------------------------------
    */

    'review' => [
        'min_rating' => 1,
        'max_rating' => 5,
        'allow_anonymous' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Notification Settings
    |--------------------------------------------------------------------------
    */

    'notifications' => [
        'channels' => ['mail', 'database'],
        'send_sms' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | File Upload Settings
    |--------------------------------------------------------------------------
    */

    'uploads' => [
        'avatar_max_size' => 2048, // KB
        'document_max_size' => 5120, // KB
        'service_image_max_size' => 3072, // KB
        'allowed_image_types' => ['jpg', 'jpeg', 'png', 'gif', 'webp'],
        'allowed_document_types' => ['pdf', 'jpg', 'jpeg', 'png'],
    ],

];
