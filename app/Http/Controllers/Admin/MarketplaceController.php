<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MarketplaceProduct;

class MarketplaceController extends Controller
{
    public function index()
    {
        $products = MarketplaceProduct::orderBy('created_at', 'desc')->get();

        return view('admin.marketplace.index', compact('products'));
    }
}
