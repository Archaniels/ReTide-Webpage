<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BlogPostsController;
use App\Http\Controllers\MarketplaceProductController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\Admin\DonationUpdateController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AccountController as AdminAccountController;
use App\Http\Controllers\Admin\MarketplaceController as AdminMarketplaceController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // User Accounts Management
    Route::get('/accounts', [AdminAccountController::class, 'index'])->name('accounts.index');
    Route::patch('/accounts/{user}/role', [AdminAccountController::class, 'updateRole'])->name('accounts.updateRole');
    Route::delete('/accounts/{user}', [AdminAccountController::class, 'destroy'])->name('accounts.destroy');

    // Marketplace Management
    Route::get('/marketplace', [AdminMarketplaceController::class, 'index'])->name('marketplace.index');
    // Using existing controllers for store/update/destroy since logic is identical
    Route::get('/marketplace/create', [MarketplaceProductController::class, 'create'])->name('marketplace.create');
    Route::post('/marketplace', [MarketplaceProductController::class, 'store'])->name('marketplace.store');
    Route::get('/marketplace/{id}/edit', [MarketplaceProductController::class, 'edit'])->name('marketplace.edit');
    Route::put('/marketplace/{id}', [MarketplaceProductController::class, 'update'])->name('marketplace.update');
    Route::delete('/marketplace/{id}', [MarketplaceProductController::class, 'destroy'])->name('marketplace.destroy');

    // Blog Management
    Route::get('/blogs', [AdminBlogController::class, 'index'])->name('blogs.index');
    // Using existing controllers for store/update/destroy
    Route::get('/blogs/create', [BlogPostsController::class, 'create'])->name('blogs.create');
    Route::post('/blogs', [BlogPostsController::class, 'store'])->name('blogs.store');
    Route::get('/blogs/{id}/edit', [BlogPostsController::class, 'edit'])->name('blogs.edit');
    Route::put('/blogs/{id}', [BlogPostsController::class, 'update'])->name('blogs.update');
    Route::delete('/blogs/{id}', [BlogPostsController::class, 'destroy'])->name('blogs.destroy');

    // Donations Management
    Route::get('/donations', [DonationController::class, 'adminIndex'])->name('donations.index');
    Route::delete('/donations/{donation}', [DonationController::class, 'adminDestroy'])->name('donations.destroy');
    Route::get('/donations/{donation}/updates', [DonationUpdateController::class, 'index'])->name('donations.updates.index');
    Route::get('/donations/{donation}/updates/create', [DonationUpdateController::class, 'create'])->name('donations.updates.create');
    Route::post('/donations/{donation}/updates', [DonationUpdateController::class, 'store'])->name('donations.updates.store');
});

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated Normal User Routes
Route::middleware(['auth'])->group(function () {
    Route::middleware(['not_admin'])->group(function () {
        Route::get('/', function () {
            return view('home');
        })->name('home');

        Route::get('/about', function () {
            return view('about');
        });

        Route::get('/contact', function () {
            return view('contact');
        });

        Route::get('/account', function () {
            return view('account');
        });

        // Public Blog
        Route::get('/blog', [BlogPostsController::class, 'index'])->name('blog.index');

        // Public Marketplace
        Route::get('/marketplace', [MarketplaceProductController::class, 'index'])->name('marketplace.index');

        // Donation
        Route::get('/donation', [DonationController::class, 'index'])->name('donation.index');
        Route::post('/donation', [DonationController::class, 'store'])->name('donation.store');
        Route::get('/donation/success', [DonationController::class, 'success'])->name('donation.success');

        // Account Page CRUD
        Route::get('/account', [AccountController::class, 'index'])->name('account.index');
        Route::put('/account', [AccountController::class, 'update'])->name('account.update');
        Route::delete('/account', [AccountController::class, 'destroy'])->name('account.destroy');
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
