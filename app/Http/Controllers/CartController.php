<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MarketplaceProduct;
use App\Models\Payment;
use Midtrans\Config;
use Midtrans\Snap;

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
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('marketplace.index')->with('error', 'Cart is empty!');
        }

        $totalAmount = 0;
        $itemDetails = [];

        foreach ($cart as $id => $details) {
            $totalAmount += $details['price'] * $details['quantity'];
            $itemDetails[] = [
                'id' => $id,
                'price' => $details['price'],
                'quantity' => $details['quantity'],
                'name' => $details['name'],
            ];
        }

        // Set Midtrans configuration
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        $orderId = 'MKT-' . time() . '-' . auth()->id();

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $totalAmount,
            ],
            'customer_details' => [
                'first_name' => auth()->user()->name,
                'email' => auth()->user()->email,
            ],
            'item_details' => $itemDetails,
            'callbacks' => [
                'finish' => route('marketplace.success'),
                'unfinish' => route('marketplace.index'),
                'error' => route('marketplace.index'),
            ],
        ];

        try {
            $snapResponse = Snap::createTransaction($params);
            $redirectUrl = $snapResponse->redirect_url;
            
            // Create Payment record ONLY if Snap transaction succeeded
            Payment::create([
                'order_id' => $orderId,
                'payment_type' => 'marketplace',
                'status' => 'pending',
                'gross_amount' => $totalAmount,
                'user_id' => auth()->id(),
                'payload' => [
                    'redirect_url' => $snapResponse->redirect_url,
                    'token' => $snapResponse->token,
                    'created_at' => now()->toDateTimeString(),
                ],
            ]);
            
            // Clear the cart session after creating transaction
            session()->forget('cart');

            return redirect()->away($redirectUrl);
        } catch (\Exception $e) {
            \Log::error('Midtrans Snap Error (Marketplace): ' . $e->getMessage());
            return back()->with('error', 'Failed to create payment: ' . $e->getMessage());
        }
    }
}