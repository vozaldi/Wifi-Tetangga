<?php

/**
 * Route for admin
 * 
 * Prefix: /admin
 * Namespace: admin.
 * 
 * Example route name: admin.auth.login -> /admin/auth/login
 */

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductVariantController;
use App\Http\Middleware\TablarAdminLayout;

// Admin Authentication Routes
Route::prefix('auth')->name('auth.')->group(function () {
    // Login Routes
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    // Password Reset Routes
    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
});

Route::group([
    'middleware' => ['auth:admin', TablarAdminLayout::class],
], function() {
    Route::get('/dashboard', function() {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::resource('branch', BranchController::class);

    Route::prefix('/data')->group(function() {
        Route::resource('product', ProductController::class);
        Route::resource('product-variant', ProductVariantController::class);
    });
});
