<?php

use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SubcategoryController;
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
    | Role Management Routes (Super Admin or manage_settings.roles permission)
    |--------------------------------------------------------------------------
    */
    Route::prefix('roles')->name('admin.roles.')->middleware('admin.permission:manage_settings.roles')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('index');
        Route::get('/create', [RoleController::class, 'create'])->name('create');
        Route::post('/', [RoleController::class, 'store'])->name('store');
        Route::get('/{role}/edit', [RoleController::class, 'edit'])->name('edit');
        Route::put('/{role}', [RoleController::class, 'update'])->name('update');
        Route::delete('/{role}', [RoleController::class, 'destroy'])->name('destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | Admin User Management Routes (Super Admin or manage_settings.admins permission)
    |--------------------------------------------------------------------------
    */
    Route::prefix('admins')->name('admin.admins.')->middleware('admin.permission:manage_settings.admins')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::get('/create', [AdminController::class, 'create'])->name('create');
        Route::post('/', [AdminController::class, 'store'])->name('store');
        Route::get('/{admin}', [AdminController::class, 'show'])->name('show');
        Route::get('/{admin}/edit', [AdminController::class, 'edit'])->name('edit');
        Route::put('/{admin}', [AdminController::class, 'update'])->name('update');
        Route::patch('/{admin}/toggle-status', [AdminController::class, 'toggleStatus'])->name('toggle-status');
        Route::delete('/{admin}', [AdminController::class, 'destroy'])->name('destroy');
        Route::delete('/{admin}/avatar', [AdminController::class, 'removeAvatar'])->name('remove-avatar');
    });

    /*
    |--------------------------------------------------------------------------
    | Activity Logs Routes (Super Admin or manage_settings.admins permission)
    |--------------------------------------------------------------------------
    */
    Route::prefix('activity-logs')->name('admin.activity-logs.')->middleware('admin.permission:manage_settings.admins')->group(function () {
        Route::get('/', [ActivityLogController::class, 'index'])->name('index');
        Route::get('/{log}', [ActivityLogController::class, 'show'])->name('show');
    });

    /*
    |--------------------------------------------------------------------------
    | Category Management Routes (manage_categories permission)
    |--------------------------------------------------------------------------
    */
    Route::prefix('categories')->name('admin.categories.')->middleware('admin.permission:manage_categories.view')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/', [CategoryController::class, 'store'])->name('store');
        Route::get('/{category}', [CategoryController::class, 'show'])->name('show');
        Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('edit');
        Route::put('/{category}', [CategoryController::class, 'update'])->name('update');
        Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('destroy');
        Route::patch('/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('toggle-status');
        Route::patch('/{category}/toggle-featured', [CategoryController::class, 'toggleFeatured'])->name('toggle-featured');
        Route::delete('/{category}/icon', [CategoryController::class, 'removeIcon'])->name('remove-icon');
        Route::delete('/{category}/image', [CategoryController::class, 'removeImage'])->name('remove-image');
        Route::post('/update-order', [CategoryController::class, 'updateOrder'])->name('update-order');
    });

    /*
    |--------------------------------------------------------------------------
    | Subcategory Management Routes (manage_categories permission)
    |--------------------------------------------------------------------------
    */
    Route::prefix('subcategories')->name('admin.subcategories.')->middleware('admin.permission:manage_categories.view')->group(function () {
        Route::get('/', [SubcategoryController::class, 'index'])->name('index');
        Route::get('/create', [SubcategoryController::class, 'create'])->name('create');
        Route::post('/', [SubcategoryController::class, 'store'])->name('store');
        Route::get('/{subcategory}', [SubcategoryController::class, 'show'])->name('show');
        Route::get('/{subcategory}/edit', [SubcategoryController::class, 'edit'])->name('edit');
        Route::put('/{subcategory}', [SubcategoryController::class, 'update'])->name('update');
        Route::delete('/{subcategory}', [SubcategoryController::class, 'destroy'])->name('destroy');
        Route::patch('/{subcategory}/toggle-status', [SubcategoryController::class, 'toggleStatus'])->name('toggle-status');
        Route::patch('/{subcategory}/toggle-featured', [SubcategoryController::class, 'toggleFeatured'])->name('toggle-featured');
        Route::delete('/{subcategory}/image', [SubcategoryController::class, 'removeImage'])->name('remove-image');
    });

    // AJAX route for getting subcategories by category
    Route::get('/api/categories/{category}/subcategories', [SubcategoryController::class, 'getByCategory'])
        ->name('admin.api.subcategories.by-category');

    /*
    |--------------------------------------------------------------------------
    | Placeholder Routes (To be implemented in future modules)
    |--------------------------------------------------------------------------
    */

    // Users - Module 14
    // Route::prefix('users')->name('admin.users.')->middleware('admin.permission:manage_users.view')->group(function () {
    //     Route::get('/', [UserController::class, 'index'])->name('index');
    // });

    // Taskers - Module 14
    // Route::prefix('taskers')->name('admin.taskers.')->middleware('admin.permission:manage_taskers.view')->group(function () {
    //     Route::get('/', [TaskerController::class, 'index'])->name('index');
    // });

    // Bookings - Module 15
    // Route::prefix('bookings')->name('admin.bookings.')->middleware('admin.permission:manage_bookings.view')->group(function () {
    //     Route::get('/', [BookingController::class, 'index'])->name('index');
    // });

    // Payments - Module 9
    // Route::prefix('payments')->name('admin.payments.')->middleware('admin.permission:manage_payments.view')->group(function () {
    //     Route::get('/', [PaymentController::class, 'index'])->name('index');
    // });

    // Reviews - Module 10
    // Route::prefix('reviews')->name('admin.reviews.')->middleware('admin.permission:manage_reviews.view')->group(function () {
    //     Route::get('/', [ReviewController::class, 'index'])->name('index');
    // });

    // Settings - Module 16
    // Route::prefix('settings')->name('admin.settings.')->middleware('admin.permission:manage_settings.view')->group(function () {
    //     Route::get('/', [SettingController::class, 'index'])->name('index');
    // });
});
