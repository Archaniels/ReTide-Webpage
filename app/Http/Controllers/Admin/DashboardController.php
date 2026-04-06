<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Donation;
use Illuminate\Support\Facades\Http;
use App\Models\MarketplaceProduct;
use App\Models\BlogPost;

class DashboardController extends Controller
{
    public function index()
    {
        $usersCount = User::count();
        $donationsCount = Donation::count();

        // If we are using NodeJS API for products and blogs, we could fetch counts from there.
        // But for dashboard simplicity, let's use Eloquent if models exist, or Http if we want NodeJS.
        // Let's use Eloquent since models are in the app, or fall back to NodeJS if we prefer it.
        // Using Eloquent for fast local counts:
        $productsCount = MarketplaceProduct::count();
        $blogsCount = BlogPost::count();

        // If NodeJS is strictly preferred:
        // $productsResponse = Http::get('http://localhost:3000/products');
        // $productsCount = $productsResponse->successful() ? count($productsResponse->json()) : 0;
        // $blogsResponse = Http::get('http://localhost:3000/blogs');
        // $blogsCount = $blogsResponse->successful() ? count($blogsResponse->json()) : 0;

        return view('admin.dashboard', compact('usersCount', 'productsCount', 'blogsCount', 'donationsCount'));
    }
}
