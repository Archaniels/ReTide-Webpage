<?php

namespace Tests\Feature;

use App\Models\Donation;
use App\Models\DonationUpdate;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Mockery;
use Tests\TestCase;

class DonationFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /**
     * Test a user can view the donation index page.
     */
    public function test_user_can_view_donation_page()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('donation.index'));

        $response->assertStatus(200);
        $response->assertViewIs('donation');
        $response->assertViewHasAll(['donations', 'totalDonations', 'donationGoal', 'progressPercentage']);
    }

    /**
     * Test a user can submit a donation and midtrans is called.
     */
    public function test_user_can_submit_donation()
    {
        $user = User::factory()->create();

        // Mock the Midtrans Snap class
        $snapMock = Mockery::mock('alias:Midtrans\Snap');
        $snapMock->shouldReceive('createTransaction')
            ->once()
            ->andReturn((object) [
                'redirect_url' => 'https://mock.midtrans.com/pay',
                'token' => 'mock_token',
            ]);

        $response = $this->actingAs($user)->post(route('donation.store'), [
            'amount' => 50000,
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'message' => 'Good luck!',
        ]);

        $response->assertRedirect('https://mock.midtrans.com/pay');

        $this->assertDatabaseHas('donations', [
            'amount' => 50000,
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'message' => 'Good luck!',
            'user_id' => $user->id,
        ]);

        $this->assertDatabaseHas('payments', [
            'payment_type' => 'donation',
            'status' => 'pending',
            'gross_amount' => 50000,
            'user_id' => $user->id,
        ]);
    }

    /**
     * Test donation validation fails on invalid amount.
     */
    public function test_donation_requires_minimum_amount()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('donation.store'), [
            'amount' => 500, // Less than minimum 1000
        ]);

        $response->assertSessionHasErrors(['amount']);
        $this->assertDatabaseCount('donations', 0);
    }

    /**
     * Test a user can get donation updates via ajax.
     */
    public function test_user_can_fetch_donation_updates()
    {
        $user = User::factory()->create();
        $donation = Donation::create([
            'name' => 'Test',
            'email' => 'test@example.com',
            'amount' => 10000,
            'user_id' => $user->id,
        ]);

        DonationUpdate::create([
            'donation_id' => $donation->id,
            'title' => 'Update 1',
            'description' => 'Desc',
            'status' => 'active',
        ]);

        $response = $this->actingAs($user)->get(route('donation.updates', $donation->id));

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment(['title' => 'Update 1']);
    }

    /**
     * Test user can access success page.
     */
    public function test_user_can_view_success_page()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('donation.success'));

        $response->assertStatus(200);
        $response->assertViewIs('donation_success');
    }

    /**
     * Test admin can view all donations.
     */
    public function test_admin_can_view_donations_index()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create();
        Donation::create([
            'name' => 'Test',
            'email' => 'test@example.com',
            'amount' => 10000,
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.donations.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.donations.index');
        $response->assertViewHas('donations');
    }

    /**
     * Test admin can delete a donation.
     */
    public function test_admin_can_delete_donation()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create();
        $donation = Donation::create([
            'name' => 'Test',
            'email' => 'test@example.com',
            'amount' => 10000,
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($admin)->delete(route('admin.donations.destroy', $donation->id));

        $response->assertRedirect(route('admin.donations.index'));
        $response->assertSessionHas('success', 'Donasi berhasil dihapus');
        $this->assertDatabaseMissing('donations', ['id' => $donation->id]);
    }

    /**
     * Test non-admin cannot view donations index.
     */
    public function test_non_admin_cannot_view_donations_index()
    {
        $user = User::factory()->create(['role' => 'user']); // Assuming 'user' is default role

        $response = $this->actingAs($user)->get(route('admin.donations.index'));

        $response->assertForbidden(); // Or redirected depending on how admin middleware is configured
    }
}
