<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MarketplaceProduct;

class CartController extends Controller
{
    /**
     * Add a product to the cart using the session.
     */
    public function add(Request $request)
    {
        $productId = $request->input('product_id');
        $product = MarketplaceProduct::findOrFail($productId);

        // Get existing cart from session or initialize empty array
        $cart = session()->get('cart', []);

        // Check if product is already in cart
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        } else {
            $cart[$productId] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image
            ];
        }

        session()->put('cart', $cart);

        return response()->json([
            'status' => 'success',
            'message' => $product->name . ' added to cart!'
        ]);
    }

    /**
     * Simulate a successful checkout process.
     */
    public function checkout()
    {
        // Clear the cart session after "purchase"
        session()->forget('cart');

        return redirect()->route('marketplace.index')
            ->with('success', 'Purchase successful! Your order is being processed.');
    }
}