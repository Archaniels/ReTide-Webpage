<?php

namespace Tests\Unit;

use App\Models\Donation;
use App\Models\DonationUpdate;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class DonationBPTTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        config(['midtrans.server_key' => 'test-server-key']);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /**
     * TC01 - Path: 1
     * Description: Access the public donation dashboard page to view contribution list and overall progress.
     */
    public function test_tc01_public_donation_dashboard_page(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        
        Donation::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'amount' => 50000,
            'message' => 'Support!',
            'user_id' => $user->id,
        ]);
        
        $otherUser = User::factory()->create(['role' => 'user']);
        Donation::create([
            'name' => 'Other',
            'email' => 'other@example.com',
            'amount' => 30000,
            'message' => 'More support!',
            'user_id' => $otherUser->id,
        ]);

        $response = $this->actingAs($user)->get('/donation');

        $response->assertStatus(200);
        $response->assertViewIs('donation');
        $response->assertViewHasAll(['donations', 'totalDonations', 'donationGoal', 'progressPercentage']);
        
        $this->assertEquals(80000, $response->viewData('totalDonations'));
        $this->assertEquals(100000000, $response->viewData('donationGoal'));
        $this->assertEquals(0.08, $response->viewData('progressPercentage'));
        
        $viewDonations = $response->viewData('donations');
        $this->assertCount(1, $viewDonations);
        $this->assertEquals(50000, $viewDonations->first()->amount);
    }

    /**
     * TC02 - Path: 1 -> 2
     * Description: Retrieve updates for a non-existent donation ID.
     */
    public function test_tc02_retrieve_updates_for_nonexistent_donation(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)->get('/donation/99999/updates');

        $response->assertStatus(404);
    }

    /**
     * TC03 - Path: 1 -> 3 -> 4
     * Description: Retrieve updates for an existing donation.
     */
    public function test_tc03_retrieve_updates_for_existent_donation(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        $donation = Donation::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'amount' => 50000,
            'user_id' => $user->id,
        ]);

        $update = DonationUpdate::create([
            'donation_id' => $donation->id,
            'title' => 'Initial Update',
            'description' => 'Working on the coast cleanup.',
            'status' => 'In Progress',
        ]);

        $response = $this->actingAs($user)->get("/donation/{$donation->id}/updates");

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment([
            'donation_id' => $donation->id,
            'title' => 'Initial Update',
            'description' => 'Working on the coast cleanup.',
            'status' => 'In Progress',
        ]);
    }

    /**
     * TC04 - Path: 1 -> 2
     * Description: Submit a donation with an invalid amount (under minimum requirement).
     */
    public function test_tc04_submit_donation_with_invalid_amount(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)->post('/donation', [
            'amount' => 500,
            'email' => 'test@example.com',
            'name' => 'John Doe',
            'message' => 'Support!',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['amount']);
        $this->assertDatabaseCount('donations', 0);
    }

    /**
     * TC05 - Path: 1 -> 3 -> 4 -> 5 -> 6
     * Description: Successfully submit a donation resulting in a successful Midtrans Snap transaction redirect.
     */
    public function test_tc05_submit_donation_successfully_with_midtrans_redirect(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $snapMock = Mockery::mock('alias:Midtrans\Snap');
        $snapMock->shouldReceive('createTransaction')
            ->once()
            ->andReturn((object) [
                'redirect_url' => 'https://mock.midtrans.com/pay',
                'token' => 'mock_token',
            ]);

        $response = $this->actingAs($user)->post('/donation', [
            'amount' => 50000,
            'email' => 'user@example.com',
            'name' => 'Jane Doe',
            'message' => 'Good luck!',
        ]);

        $response->assertRedirect('https://mock.midtrans.com/pay');

        $this->assertDatabaseHas('donations', [
            'amount' => 50000,
            'email' => 'user@example.com',
            'name' => 'Jane Doe',
            'message' => 'Good luck!',
            'user_id' => $user->id,
        ]);

        $this->assertDatabaseHas('payments', [
            'payment_type' => 'donation',
            'status' => 'pending',
            'gross_amount' => 50000,
            'user_id' => $user->id,
        ]);
        
        $payment = \App\Models\Payment::first();
        $this->assertStringStartsWith('DON-', $payment->order_id);
    }

    /**
     * TC06 - Path: 1 -> 3 -> 4 -> 5 -> 7
     * Description: Submit a valid donation but Midtrans Snap API call fails due to a connection or configuration exception.
     */
    public function test_tc06_submit_donation_with_midtrans_failure(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $snapMock = Mockery::mock('alias:Midtrans\Snap');
        $snapMock->shouldReceive('createTransaction')
            ->once()
            ->andThrow(new \Exception("Midtrans Connection Error"));

        $response = $this->actingAs($user)->post('/donation', [
            'amount' => 50000,
            'email' => 'user@example.com',
            'name' => 'Jane Doe',
            'message' => 'Good luck!',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas('error', 'Failed to create donation payment: Midtrans Connection Error');

        $this->assertDatabaseHas('donations', [
            'amount' => 50000,
            'email' => 'user@example.com',
            'name' => 'Jane Doe',
            'message' => 'Good luck!',
            'user_id' => $user->id,
        ]);

        $this->assertDatabaseCount('payments', 0);
    }

    /**
     * TC07 - Path: 1
     * Description: View the donation success landing page after a successful transaction.
     */
    public function test_tc07_view_donation_success_page(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)->get('/donation/success');

        $response->assertStatus(200);
        $response->assertViewIs('donation_success');
    }

    /**
     * TC08 - Path: 1
     * Description: Access all donations management page in admin panel.
     */
    public function test_tc08_admin_access_donations_management_page(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'user']);
        
        Donation::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'amount' => 50000,
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($admin)->get('/admin/donations');

        $response->assertStatus(200);
        $response->assertViewIs('admin.donations.index');
        $response->assertViewHas('donations');
        $this->assertCount(1, $response->viewData('donations'));
    }

    /**
     * TC09 - Path: 1 -> 2
     * Description: Attempt to delete a non-existent donation.
     */
    public function test_tc09_admin_delete_nonexistent_donation(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->delete('/admin/donations/99999');

        $response->assertStatus(404);
    }

    /**
     * TC10 - Path: 1 -> 3 -> 4
     * Description: Successfully delete a donation record from the database.
     */
    public function test_tc10_admin_delete_existent_donation_successfully(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'user']);
        $donation = Donation::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'amount' => 50000,
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($admin)->delete("/admin/donations/{$donation->id}");

        $response->assertRedirect(route('admin.donations.index'));
        $response->assertSessionHas('success', 'Donasi berhasil dihapus');
        $this->assertDatabaseMissing('donations', ['id' => $donation->id]);
    }

    /**
     * TC11 - Path: 1 -> 2
     * Description: View donation updates for a non-existent donation.
     */
    public function test_tc11_admin_view_updates_for_nonexistent_donation(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/admin/donations/99999/updates');

        $response->assertStatus(404);
    }

    /**
     * TC12 - Path: 1 -> 3 -> 4 -> 5
     * Description: Fetch donation updates list via AJAX request.
     */
    public function test_tc12_admin_fetch_updates_list_via_ajax(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'user']);
        $donation = Donation::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'amount' => 50000,
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($admin)
            ->withHeaders(['X-Requested-With' => 'XMLHttpRequest'])
            ->get("/admin/donations/{$donation->id}/updates");

        $response->assertStatus(200);
        $response->assertViewIs('admin.donation_updates.partials.updates_list');
    }

    /**
     * TC13 - Path: 1 -> 3 -> 4 -> 6
     * Description: Access donation updates list via standard GET request.
     */
    public function test_tc13_admin_access_updates_list_via_standard_get(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'user']);
        $donation = Donation::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'amount' => 50000,
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($admin)->get("/admin/donations/{$donation->id}/updates");

        $response->assertStatus(200);
        $response->assertViewIs('admin.donation_updates.index');
        $response->assertViewHasAll(['donation', 'updates']);
    }

    /**
     * TC14 - Path: 1 -> 2
     * Description: Attempt to access update creation page for a non-existent donation.
     */
    public function test_tc14_admin_access_update_creation_page_for_nonexistent_donation(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/admin/donations/99999/updates/create');

        $response->assertStatus(404);
    }

    /**
     * TC15 - Path: 1 -> 3
     * Description: Access the form to create a new donation update.
     */
    public function test_tc15_admin_access_update_creation_page_for_existent_donation(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'user']);
        $donation = Donation::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'amount' => 50000,
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($admin)->get("/admin/donations/{$donation->id}/updates/create");

        $response->assertStatus(200);
        $response->assertViewIs('admin.donation_updates.create');
        $response->assertViewHas('donation');
    }

    /**
     * TC16 - Path: 1 -> 2
     * Description: Attempt to store an update for a non-existent donation.
     */
    public function test_tc16_admin_store_update_for_nonexistent_donation(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->post('/admin/donations/99999/updates', [
            'title' => 'Restoring Mangroves',
            'description' => 'We planted 500 seedlings.',
            'status' => 'In Progress',
        ]);

        $response->assertStatus(404);
    }

    /**
     * TC17 - Path: 1 -> 3 -> 4
     * Description: Submit a new donation update with invalid inputs causing validation errors.
     */
    public function test_tc17_admin_store_update_with_invalid_inputs(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'user']);
        $donation = Donation::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'amount' => 50000,
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($admin)->post("/admin/donations/{$donation->id}/updates", [
            'title' => '',
            'description' => '',
            'status' => '',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['title', 'description', 'status']);
        $this->assertDatabaseCount('donation_updates', 0);
    }

    /**
     * TC18 - Path: 1 -> 3 -> 5 -> 6
     * Description: Successfully create and store a new donation update.
     */
    public function test_tc18_admin_store_update_successfully(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'user']);
        $donation = Donation::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'amount' => 50000,
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($admin)->post("/admin/donations/{$donation->id}/updates", [
            'title' => 'Initial Restoration Step',
            'description' => 'Cleaned up plastic trash along the coast.',
            'status' => 'Completed',
        ]);

        $response->assertRedirect(route('admin.donations.updates.index', $donation->id));
        $response->assertSessionHas('success', 'Update donasi berhasil ditambahkan');

        $this->assertDatabaseHas('donation_updates', [
            'donation_id' => $donation->id,
            'title' => 'Initial Restoration Step',
            'description' => 'Cleaned up plastic trash along the coast.',
            'status' => 'Completed',
        ]);
    }
}
