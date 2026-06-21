<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\Donation;
use App\Models\MarketplaceProduct;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $usersCount = User::count();
        $donationsCount = Donation::count();

        $productsCount = MarketplaceProduct::count();
        $blogsCount = BlogPost::count();

        return view('admin.dashboard', compact('usersCount', 'productsCount', 'blogsCount', 'donationsCount'));
    }
}
