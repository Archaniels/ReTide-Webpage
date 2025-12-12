<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BlogPostsController;
use App\Http\Controllers\MarketplaceProductController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('home');
});

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

Route::get('/donation', function () {
    return view('donation');
});

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