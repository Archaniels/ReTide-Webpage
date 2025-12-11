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
Route::get('/blog', [BlogPostsController::class, 'index']);
Route::post('/blog', [BlogPostsController::class, 'store']);
Route::get('/blog/{id}/edit', [BlogPostsController::class, 'edit']);
Route::put('/blog/{id}', [BlogPostsController::class, 'update']);
Route::delete('/blog/{id}', [BlogPostsController::class, 'delete']);

// Marketplace Products CRUD
Route::get('/marketplace', [MarketplaceProductController::class, 'index']);
Route::post('/marketplace', [MarketplaceProductController::class, 'store']);
Route::get('/marketplace/{id}/edit', [MarketplaceProductController::class, 'edit']);
Route::put('/marketplace/{id}', [MarketplaceProductController::class, 'update']);
Route::delete('/marketplace/{id}', [MarketplaceProductController::class, 'delete']);