<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Tasker\AvailabilityController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\ProfileController as UserProfileController;
use App\Http\Controllers\Tasker\DashboardController as TaskerDashboardController;
use App\Http\Controllers\Tasker\ProfileController;
use App\Http\Controllers\Tasker\RegistrationController;
use App\Http\Controllers\Tasker\ServiceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| Public Placeholder Routes (Browse Services - Coming Soon)
|--------------------------------------------------------------------------
*/
Route::get('/categories', function () {
    return view('public.coming-soon', ['feature' => 'Browse Categories']);
})->name('categories.index');

Route::get('/categories/{slug}', function ($slug) {
    return view('public.coming-soon', ['feature' => 'Category Details']);
})->name('categories.show');

Route::get('/taskers', function () {
    return view('public.coming-soon', ['feature' => 'Browse Taskers']);
})->name('taskers.index');

Route::get('/taskers/{id}', function ($id) {
    return view('public.coming-soon', ['feature' => 'Tasker Profile']);
})->name('taskers.show');

Route::get('/search', function () {
    return view('public.coming-soon', ['feature' => 'Search']);
})->name('search');

// Guest Routes (not authenticated)
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Register
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // Password Reset
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    /*
    |--------------------------------------------------------------------------
    | OTP Verification Routes
    |--------------------------------------------------------------------------
    */
    Route::get('/verify-otp', [AuthController::class, 'showOTPForm'])->name('otp.verify');
    Route::post('/verify-otp', [AuthController::class, 'verifyOTP']);
    Route::post('/resend-otp', [AuthController::class, 'resendOTP'])->name('otp.resend');

    // Email Verification (legacy - kept for backward compatibility)
    Route::get('/email/verify', [AuthController::class, 'showOTPForm'])->name('verification.notice');
    Route::post('/email/verification-notification', [AuthController::class, 'resendOTP'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    // Become a Tasker Landing
    Route::get('/become-a-tasker', function () {
        return view('tasker.become-tasker');
    })->name('become-tasker');

    /*
    |--------------------------------------------------------------------------
    | User Dashboard Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('dashboard')->name('user.')->group(function () {
        // Dashboard
        Route::get('/', [UserDashboardController::class, 'index'])->name('dashboard');

        // Profile
        Route::get('/profile', [UserProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [UserProfileController::class, 'update'])->name('profile.update');
        Route::post('/profile/avatar', [UserProfileController::class, 'updateAvatar'])->name('profile.avatar');
        Route::delete('/profile/avatar', [UserProfileController::class, 'removeAvatar'])->name('profile.avatar.remove');

        // Change Password
        Route::get('/change-password', [UserProfileController::class, 'showChangePasswordForm'])->name('password.change');
        Route::post('/change-password', [UserProfileController::class, 'changePassword'])->name('password.update');

        // Notification Preferences
        Route::post('/notification-preferences', [UserProfileController::class, 'updateNotificationPreferences'])
            ->name('notifications.preferences');

        // Delete Account
        Route::get('/delete-account', [UserProfileController::class, 'showDeleteConfirmation'])->name('account.delete.show');
        Route::delete('/delete-account', [UserProfileController::class, 'deleteAccount'])->name('account.delete');

        /*
        |--------------------------------------------------------------------------
        | User Dashboard Placeholder Routes (Coming Soon)
        |--------------------------------------------------------------------------
        */

        // Bookings
        Route::get('/bookings', function () {
            return view('user.coming-soon', ['feature' => 'My Bookings']);
        })->name('bookings.index');

        Route::get('/bookings/{id}', function ($id) {
            return view('user.coming-soon', ['feature' => 'Booking Details']);
        })->name('bookings.show');

        // Reviews
        Route::get('/reviews', function () {
            return view('user.coming-soon', ['feature' => 'My Reviews']);
        })->name('reviews.index');

        // Messages
        Route::get('/messages', function () {
            return view('user.coming-soon', ['feature' => 'Messages']);
        })->name('messages.index');

        Route::get('/messages/{id}', function ($id) {
            return view('user.coming-soon', ['feature' => 'Conversation']);
        })->name('messages.show');

        // Notifications
        Route::get('/notifications', function () {
            return view('user.coming-soon', ['feature' => 'Notifications']);
        })->name('notifications.index');

        // Payment Methods
        Route::get('/payment-methods', function () {
            return view('user.coming-soon', ['feature' => 'Payment Methods']);
        })->name('payment-methods.index');
    });

    /*
    |--------------------------------------------------------------------------
    | Tasker Dashboard Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('tasker')->name('tasker.')->middleware(['is_tasker', 'tasker_verified'])->group(function () {
        // Dashboard
        Route::get('/dashboard', [TaskerDashboardController::class, 'index'])->name('dashboard');
    });


    // Become a Tasker - Landing Pages
    Route::get('/become-tasker', [RegistrationController::class, 'index'])->name('become-tasker');
    Route::get('/become-a-tasker', [RegistrationController::class, 'index'])->name('become-tasker.index');

    // Become a Tasker - Start (alias for compatibility with existing blade files)
    Route::post('/become-tasker/start', [RegistrationController::class, 'start'])->name('become-tasker.start');

    Route::prefix('tasker/register')->name('tasker.register.')->group(function () {
        Route::post('/start', [RegistrationController::class, 'start'])->name('start');

        // Step 1 - Profile
        Route::get('/step-1', [RegistrationController::class, 'showStep1'])->name('step1');
        Route::post('/step-1', [RegistrationController::class, 'processStep1'])->name('step1.store');

        // Step 2 - Categories
        Route::get('/step-2', [RegistrationController::class, 'showStep2'])->name('step2');
        Route::post('/step-2', [RegistrationController::class, 'processStep2'])->name('step2.store');

        // Step 3 - Availability
        Route::get('/step-3', [RegistrationController::class, 'showStep3'])->name('step3');
        Route::post('/step-3', [RegistrationController::class, 'processStep3'])->name('step3.store');

        // Step 4 - Verification
        Route::get('/step-4', [RegistrationController::class, 'showStep4'])->name('step4');
        Route::post('/step-4', [RegistrationController::class, 'processStep4'])->name('step4.store');

        // Complete
        Route::get('/complete', [RegistrationController::class, 'complete'])->name('complete');
    });

    Route::prefix('tasker')->name('tasker.')->middleware(['auth', 'is_tasker', 'tasker_verified'])->group(function () {

        // Dashboard
        Route::get('/dashboard', [TaskerDashboardController::class, 'index'])->name('dashboard');

        // Profile Management
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo');
        Route::delete('/profile/photo', [ProfileController::class, 'removePhoto'])->name('profile.photo.remove');
        Route::put('/profile/vehicle', [ProfileController::class, 'updateVehicle'])->name('profile.vehicle');
        Route::post('/profile/toggle-availability', [ProfileController::class, 'toggleAvailability'])->name('profile.toggle-availability');
        Route::get('/profile/verification', [ProfileController::class, 'verification'])->name('profile.verification');
        Route::get('/profile/earnings', [ProfileController::class, 'earnings'])->name('profile.earnings');

        // Services Management
        Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
        Route::get('/services/create', [ServiceController::class, 'create'])->name('services.create');
        Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
        Route::get('/services/{service}/edit', [ServiceController::class, 'edit'])->name('services.edit');
        Route::put('/services/{service}', [ServiceController::class, 'update'])->name('services.update');
        Route::post('/services/{service}/toggle', [ServiceController::class, 'toggle'])->name('services.toggle');
        Route::delete('/services/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');
        Route::get('/services/subcategories/{category}', [ServiceController::class, 'getSubcategories'])->name('services.subcategories');

        // Availability Management (REPLACE ALL AVAILABILITY ROUTES WITH THIS)
        Route::get('/availability', [AvailabilityController::class, 'index'])->name('availability.index');
        Route::post('/availability', [AvailabilityController::class, 'store'])->name('availability.store');
        Route::delete('/availability/{availability}', [AvailabilityController::class, 'destroy'])->name('availability.destroy');
        Route::put('/availability/schedule', [AvailabilityController::class, 'updateSchedule'])->name('availability.schedule');
        Route::post('/availability/block-date', [AvailabilityController::class, 'addBlockedDate'])->name('availability.block-date');
        Route::delete('/availability/unblock-date/{blockedDate}', [AvailabilityController::class, 'removeBlockedDate'])->name('availability.unblock-date');
        Route::get('/availability/blocked-dates/calendar', [AvailabilityController::class, 'getBlockedDates'])->name('availability.blocked-dates.calendar');
        Route::post('/availability/copy-day', [AvailabilityController::class, 'copyDay'])->name('availability.copy-day');
        Route::post('/availability/preset', [AvailabilityController::class, 'setPreset'])->name('availability.preset');
    });
    Route::get('/contact', fn() => redirect()->route('home'))->name('contact');
    // Tasker Verification Pending Page
    Route::get('/tasker/verification-pending', function () {
        return view('tasker.verification-pending');
    })->middleware('is_tasker')->name('tasker.verification-pending');
});
