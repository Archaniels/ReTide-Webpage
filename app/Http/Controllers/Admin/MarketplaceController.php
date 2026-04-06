<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MarketplaceProduct;
use Illuminate\Support\Facades\Http;

class MarketplaceController extends Controller
{
    public function index()
    {
        $products = MarketplaceProduct::orderBy('created_at', 'desc')->get();
        return view('admin.marketplace.index', compact('products'));
    }
}
