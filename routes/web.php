<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\ProfileController as UserProfileController;
use App\Http\Controllers\Tasker\DashboardController as TaskerDashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('search');

// Categories (Public)
Route::get('/categories', [HomeController::class, 'categories'])->name('categories.index');
Route::get('/categories/{slug}', [HomeController::class, 'category'])->name('categories.show');

// Taskers (Public)
Route::get('/taskers', [HomeController::class, 'taskers'])->name('taskers.index');
Route::get('/taskers/{id}', [HomeController::class, 'tasker'])->name('taskers.show');

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

    // Email Verification
    Route::get('/email/verify', [AuthController::class, 'showVerificationNotice'])
        ->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])
        ->middleware('signed')
        ->name('verification.verify');
    Route::post('/email/verification-notification', [AuthController::class, 'resendVerificationEmail'])
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

        // Bookings (placeholder for Module 7)
        Route::get('/bookings', function () {
            return view('user.bookings.index', ['bookings' => collect([])]);
        })->name('bookings.index');
        Route::get('/bookings/{id}', function ($id) {
            return redirect()->route('user.bookings.index');
        })->name('bookings.show');

        // Reviews (placeholder for Module 10)
        Route::get('/reviews', function () {
            return view('user.reviews.index', ['reviews' => collect([])]);
        })->name('reviews.index');

        // Messages (placeholder for Module 11)
        Route::get('/messages', function () {
            return view('user.messages.index', ['conversations' => collect([])]);
        })->name('messages.index');

        // Notifications (placeholder for Module 17)
        Route::get('/notifications', function () {
            return view('user.notifications.index', ['notifications' => collect([])]);
        })->name('notifications.index');

        // Profile
        Route::get('/profile', [UserProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [UserProfileController::class, 'update'])->name('profile.update');
        Route::post('/profile/avatar', [UserProfileController::class, 'updateAvatar'])->name('profile.avatar');
        Route::delete('/profile/avatar', [UserProfileController::class, 'removeAvatar'])->name('profile.avatar.remove');

        // Change Password
        Route::get('/change-password', [UserProfileController::class, 'showChangePasswordForm'])->name('profile.password');
        Route::post('/change-password', [UserProfileController::class, 'changePassword'])->name('password.update');

        // Notification Preferences
        Route::post('/notification-preferences', [UserProfileController::class, 'updateNotificationPreferences'])
            ->name('notifications.preferences');

        // Delete Account
        Route::get('/delete-account', [UserProfileController::class, 'showDeleteConfirmation'])->name('account.delete.show');
        Route::delete('/delete-account', [UserProfileController::class, 'deleteAccount'])->name('account.delete');
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

    // Tasker Verification Pending Page
    Route::get('/tasker/verification-pending', function () {
        return view('tasker.verification-pending');
    })->middleware('is_tasker')->name('tasker.verification-pending');
});
