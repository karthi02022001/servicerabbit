<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
| All routes in this file are prefixed with '/admin'
*/

// Guest Routes (not authenticated as admin)
Route::middleware('guest:admin')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'login'])->name('admin.login.submit');
});

// Authenticated Admin Routes
Route::middleware('admin.auth')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard.index');

    /*
    |--------------------------------------------------------------------------
    | User Management Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('users')->name('admin.users.')->middleware('admin.permission:manage_users.view')->group(function () {
        // Routes will be added in Module 14
    });

    /*
    |--------------------------------------------------------------------------
    | Tasker Management Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('taskers')->name('admin.taskers.')->middleware('admin.permission:manage_taskers.view')->group(function () {
        // Routes will be added in Module 14
    });

    /*
    |--------------------------------------------------------------------------
    | Booking Management Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('bookings')->name('admin.bookings.')->middleware('admin.permission:manage_bookings.view')->group(function () {
        // Routes will be added in Module 15
    });

    /*
    |--------------------------------------------------------------------------
    | Payment Management Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('payments')->name('admin.payments.')->middleware('admin.permission:manage_payments.view')->group(function () {
        // Routes will be added in Module 9
    });

    /*
    |--------------------------------------------------------------------------
    | Category Management Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('categories')->name('admin.categories.')->middleware('admin.permission:manage_categories.view')->group(function () {
        // Routes will be added in Module 3
    });

    /*
    |--------------------------------------------------------------------------
    | Review Management Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('reviews')->name('admin.reviews.')->middleware('admin.permission:manage_reviews.view')->group(function () {
        // Routes will be added in Module 10
    });

    /*
    |--------------------------------------------------------------------------
    | Settings Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('settings')->name('admin.settings.')->middleware('admin.permission:manage_settings.view')->group(function () {
        // Routes will be added in Module 16
    });

    /*
    |--------------------------------------------------------------------------
    | Role & Admin Management Routes (Super Admin Only)
    |--------------------------------------------------------------------------
    */
    Route::prefix('roles')->name('admin.roles.')->middleware('admin.permission:manage_settings.roles')->group(function () {
        // Routes will be added in Module 2
    });

    Route::prefix('admins')->name('admin.admins.')->middleware('admin.permission:manage_settings.admins')->group(function () {
        // Routes will be added in Module 2
    });
});
