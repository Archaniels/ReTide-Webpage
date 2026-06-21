<?php

namespace Tests\Feature;

use App\Models\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Midtrans\Notification;
use Tests\TestCase;

class PaymentWebhookTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Set up a mock/fake server key for Midtrans signature verification
        config(['midtrans.server_key' => 'test-server-key']);
    }

    protected function setupNotificationMock($orderId, $status, $paymentType = 'credit_card', $fraudStatus = 'accept', $transactionId = '12345678', $statusCode = '200', $grossAmount = '100000.00', $signatureKey = null): void
    {
        if ($signatureKey === null) {
            $serverKey = config('midtrans.server_key');
            $signatureKey = hash('sha512', $orderId.$statusCode.$grossAmount.$serverKey);
        }

        $mock = \Mockery::mock(Notification::class);
        $mock->transaction_status = $status;
        $mock->payment_type = $paymentType;
        $mock->order_id = $orderId;
        $mock->fraud_status = $fraudStatus;
        $mock->transaction_id = $transactionId;
        $mock->status_code = $statusCode;
        $mock->gross_amount = $grossAmount;
        $mock->signature_key = $signatureKey;

        $this->app->instance(Notification::class, $mock);
    }

    protected function setupNotificationStub($orderId, $status, $paymentType = 'credit_card', $fraudStatus = 'accept', $transactionId = '12345678'): void
    {
        $this->setupNotificationMock($orderId, $status, $paymentType, $fraudStatus, $transactionId);
    }

    // =========================================================================
    // STATUS TRANSITION TESTS
    // =========================================================================

    public function test_webhook_handles_settlement_status_successfully(): void
    {
        $payment = Payment::create([
            'order_id' => 'MKT-9901',
            'payment_type' => 'marketplace',
            'status' => 'pending',
            'gross_amount' => 100000,
        ]);

        $this->setupNotificationStub('MKT-9901', 'settlement', 'credit_card', 'accept', 'tx-111');

        $response = $this->postJson(route('payment.notification'), [
            'order_id' => 'MKT-9901',
            'status' => 'settlement',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'success',
            'message' => 'Notification handled',
        ]);

        $this->assertDatabaseHas('payments', [
            'order_id' => 'MKT-9901',
            'status' => 'success',
            'transaction_id' => 'tx-111',
            'payment_type' => 'credit_card',
        ]);
    }

    public function test_webhook_handles_pending_status(): void
    {
        $payment = Payment::create([
            'order_id' => 'MKT-9902',
            'payment_type' => 'marketplace',
            'status' => 'pending',
            'gross_amount' => 100000,
        ]);

        $this->setupNotificationStub('MKT-9902', 'pending', 'bank_transfer', 'accept', 'tx-222');

        $response = $this->postJson(route('payment.notification'), []);

        $response->assertStatus(200);
        $this->assertDatabaseHas('payments', [
            'order_id' => 'MKT-9902',
            'status' => 'pending',
            'transaction_id' => 'tx-222',
            'payment_type' => 'bank_transfer',
        ]);
    }

    public function test_webhook_handles_cancel_status(): void
    {
        $payment = Payment::create([
            'order_id' => 'MKT-9903',
            'payment_type' => 'marketplace',
            'status' => 'pending',
            'gross_amount' => 100000,
        ]);

        $this->setupNotificationStub('MKT-9903', 'cancel', 'credit_card', 'accept', 'tx-333');

        $response = $this->postJson(route('payment.notification'), []);

        $response->assertStatus(200);
        $this->assertDatabaseHas('payments', [
            'order_id' => 'MKT-9903',
            'status' => 'cancelled',
        ]);
    }

    public function test_webhook_handles_expire_status(): void
    {
        $payment = Payment::create([
            'order_id' => 'MKT-9904',
            'payment_type' => 'marketplace',
            'status' => 'pending',
            'gross_amount' => 100000,
        ]);

        $this->setupNotificationStub('MKT-9904', 'expire', 'credit_card', 'accept', 'tx-444');

        $response = $this->postJson(route('payment.notification'), []);

        $response->assertStatus(200);
        $this->assertDatabaseHas('payments', [
            'order_id' => 'MKT-9904',
            'status' => 'expired',
        ]);
    }

    public function test_webhook_handles_deny_status(): void
    {
        $payment = Payment::create([
            'order_id' => 'MKT-9905',
            'payment_type' => 'marketplace',
            'status' => 'pending',
            'gross_amount' => 100000,
        ]);

        $this->setupNotificationStub('MKT-9905', 'deny', 'credit_card', 'accept', 'tx-555');

        $response = $this->postJson(route('payment.notification'), []);

        $response->assertStatus(200);
        $this->assertDatabaseHas('payments', [
            'order_id' => 'MKT-9905',
            'status' => 'denied',
        ]);
    }

    public function test_webhook_handles_capture_challenge_status(): void
    {
        $payment = Payment::create([
            'order_id' => 'MKT-9906',
            'payment_type' => 'marketplace',
            'status' => 'pending',
            'gross_amount' => 100000,
        ]);

        $this->setupNotificationStub('MKT-9906', 'capture', 'credit_card', 'challenge', 'tx-666');

        $response = $this->postJson(route('payment.notification'), []);

        $response->assertStatus(200);
        $this->assertDatabaseHas('payments', [
            'order_id' => 'MKT-9906',
            'status' => 'challenge',
        ]);
    }

    public function test_webhook_handles_capture_accept_status(): void
    {
        $payment = Payment::create([
            'order_id' => 'MKT-9907',
            'payment_type' => 'marketplace',
            'status' => 'pending',
            'gross_amount' => 100000,
        ]);

        $this->setupNotificationStub('MKT-9907', 'capture', 'credit_card', 'accept', 'tx-777');

        $response = $this->postJson(route('payment.notification'), []);

        $response->assertStatus(200);
        $this->assertDatabaseHas('payments', [
            'order_id' => 'MKT-9907',
            'status' => 'success',
        ]);
    }

    // =========================================================================
    // VALIDATION / ERROR HANDLING TESTS
    // =========================================================================

    public function test_webhook_returns_404_for_invalid_order_id(): void
    {
        $this->setupNotificationStub('MKT-NONEXISTENT', 'settlement', 'credit_card', 'accept', 'tx-888');

        $response = $this->postJson(route('payment.notification'), []);

        $response->assertStatus(404);
        $response->assertJson([
            'status' => 'error',
            'message' => 'Payment record not found',
        ]);
    }

    public function test_webhook_returns_400_for_malformed_payload(): void
    {
        $this->app->bind(Notification::class, function () {
            throw new \Exception('Malformed payload');
        });

        $response = $this->postJson(route('payment.notification'), []);

        $response->assertStatus(400);
        $response->assertJson([
            'status' => 'error',
            'message' => 'Invalid notification payload',
        ]);
    }

    // =========================================================================
    // SIGNATURE KEY VERIFICATION TESTS
    // =========================================================================

    public function test_webhook_with_valid_signature_updates_payment_status(): void
    {
        $payment = Payment::create([
            'order_id' => 'MKT-SIG-01',
            'payment_type' => 'marketplace',
            'status' => 'pending',
            'gross_amount' => 125000,
        ]);

        $this->setupNotificationMock('MKT-SIG-01', 'settlement', 'credit_card', 'accept', 'tx-sig-01', '200', '125000.00');

        $response = $this->postJson(route('payment.notification'), []);

        $response->assertStatus(200);
        $this->assertDatabaseHas('payments', [
            'order_id' => 'MKT-SIG-01',
            'status' => 'success',
        ]);
    }

    public function test_webhook_with_invalid_signature_is_rejected(): void
    {
        $payment = Payment::create([
            'order_id' => 'MKT-SIG-02',
            'payment_type' => 'marketplace',
            'status' => 'pending',
            'gross_amount' => 125000,
        ]);

        $this->setupNotificationMock(
            'MKT-SIG-02',
            'settlement',
            'credit_card',
            'accept',
            'tx-sig-02',
            '200',
            '125000.00',
            'invalid-signature-key-12345'
        );

        $response = $this->postJson(route('payment.notification'), []);

        $response->assertStatus(403);
        $response->assertJson([
            'status' => 'error',
            'message' => 'Invalid signature key',
        ]);

        $this->assertDatabaseHas('payments', [
            'order_id' => 'MKT-SIG-02',
            'status' => 'pending',
        ]);
    }
}
