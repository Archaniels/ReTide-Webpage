<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BlogPostsController;
use App\Http\Controllers\MarketplaceProductController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\Admin\DonationUpdateController;



// Route::get('/', function () {
//     return view('welcome');
// });
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/donations', [DonationController::class, 'adminIndex'])->name('donations.index');
    Route::delete('/donations/{donation}', [DonationController::class, 'adminDestroy'])->name('donations.destroy');
    Route::get('/donations/{donation}/updates', [DonationUpdateController::class, 'index'])
        ->name('donations.updates.index');

    Route::get('/donations/{donation}/updates/create', [DonationUpdateController::class, 'create'])
        ->name('donations.updates.create');

    Route::post('/donations/{donation}/updates', [DonationUpdateController::class, 'store'])
        ->name('donations.updates.store');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('home');
    })->name('home');

    Route::get('/about', function () {
        return view('about');
    });

    Route::get('/blog', function () {
        return view('blog');
    });

    Route::get('/contact', function () {
        return view('contact');
    });

    Route::get('/account', function () {
        return view('account');
    });

    Route::get('/marketplace', function () {
        return view('marketplace');
    });

    // Donation
    Route::get('/donation', [DonationController::class, 'index'])->name('donation.index');
    Route::post('/donation', [DonationController::class, 'store'])->name('donation.store');
    Route::get('/donation/success', [DonationController::class, 'success'])->name('donation.success');


    // Blog Posts CRUD
    Route::get('/blog', [BlogPostsController::class, 'index'])->name('blog.index');
    Route::get('/blog/create', [BlogPostsController::class, 'create'])->name('blog.create');
    Route::post('/blog', [BlogPostsController::class, 'store'])->name('blog.store');
    Route::get('/blog/{id}/edit', [BlogPostsController::class, 'edit'])->name('blog.edit');
    Route::put('/blog/{id}', [BlogPostsController::class, 'update'])->name('blog.update');
    Route::delete('/blog/{id}', [BlogPostsController::class, 'destroy'])->name('blog.destroy');

    // Marketplace Products CRUD
    Route::get('/marketplace', [MarketplaceProductController::class, 'index'])->name('marketplace.index');
    Route::get('/marketplace/create', [MarketplaceProductController::class, 'create'])->name('marketplace.create');
    Route::post('/marketplace', [MarketplaceProductController::class, 'store'])->name('marketplace.store');
    Route::get('/marketplace/{id}/edit', [MarketplaceProductController::class, 'edit'])->name('marketplace.edit');
    Route::put('/marketplace/{id}', [MarketplaceProductController::class, 'update'])->name('marketplace.update');
    Route::delete('/marketplace/{id}', [MarketplaceProductController::class, 'destroy'])->name('marketplace.destroy');

    // Account Page CRUD
    Route::get('/account', [AccountController::class, 'index'])->name('account.index');
    Route::put('/account', [AccountController::class, 'update'])->name('account.update');
    Route::delete('/account', [AccountController::class, 'destroy'])->name('account.destroy');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});