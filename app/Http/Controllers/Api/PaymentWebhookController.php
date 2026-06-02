<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Notification;
use Illuminate\Support\Facades\Log;

class PaymentWebhookController extends Controller
{
    public function handleNotification(Request $request)
    {
        // Set Midtrans configuration
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        try {
            $notif = new Notification();
        } catch (\Exception $e) {
            Log::error('Midtrans Notification Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid notification payload'
            ], 400);
        }

        $transaction = $notif->transaction_status;
        $type = $notif->payment_type;
        $orderId = $notif->order_id;
        $fraud = $notif->fraud_status;

        $payment = Payment::where('order_id', $orderId)->first();

        if (!$payment) {
            Log::warning('Payment record not found for Order ID: ' . $orderId);
            return response()->json([
                'status' => 'error',
                'message' => 'Payment record not found'
            ], 404);
        }

        // Update payment record
        if ($transaction == 'capture') {
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    $payment->status = 'challenge';
                } else {
                    $payment->status = 'success';
                }
            }
        } else if ($transaction == 'settlement') {
            $payment->status = 'success';
        } else if ($transaction == 'pending') {
            $payment->status = 'pending';
        } else if ($transaction == 'deny') {
            $payment->status = 'denied';
        } else if ($transaction == 'expire') {
            $payment->status = 'expired';
        } else if ($transaction == 'cancel') {
            $payment->status = 'cancelled';
        }

        $payment->transaction_id = $notif->transaction_id;
        $payment->payment_type = $type;
        $payment->payload = $request->all();
        $payment->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Notification handled'
        ]);
    }
}
