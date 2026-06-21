<?php

namespace Tests\Feature;

use App\Models\Donation;
use App\Models\DonationUpdate;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DonationUpdateFeatureTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test admin can view donation updates index.
     */
    public function test_admin_can_view_donation_updates_index()
    {
        $admin = User::factory()->create(['role' => 'admin']);
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
            'description' => 'Description 1',
            'status' => 'active',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.donations.updates.index', $donation->id));

        $response->assertStatus(200);
        $response->assertViewIs('admin.donation_updates.index');
        $response->assertViewHasAll(['donation', 'updates']);
    }

    /**
     * Test admin can view donation updates index via AJAX.
     */
    public function test_admin_can_view_donation_updates_ajax()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create();
        $donation = Donation::create([
            'name' => 'Test',
            'email' => 'test@example.com',
            'amount' => 10000,
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($admin)
            ->withHeaders(['X-Requested-With' => 'XMLHttpRequest'])
            ->get(route('admin.donations.updates.index', $donation->id));

        $response->assertStatus(200);
        $response->assertViewIs('admin.donation_updates.partials.updates_list');
    }

    /**
     * Test admin can view create donation update page.
     */
    public function test_admin_can_view_create_donation_update_page()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create();
        $donation = Donation::create([
            'name' => 'Test',
            'email' => 'test@example.com',
            'amount' => 10000,
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.donations.updates.create', $donation->id));

        $response->assertStatus(200);
        $response->assertViewIs('admin.donation_updates.create');
        $response->assertViewHas('donation');
    }

    /**
     * Test admin can store a donation update.
     */
    public function test_admin_can_store_donation_update()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create();
        $donation = Donation::create([
            'name' => 'Test',
            'email' => 'test@example.com',
            'amount' => 10000,
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($admin)->post(route('admin.donations.updates.store', $donation->id), [
            'title' => 'New Status Update',
            'description' => 'Everything is going well.',
            'status' => 'processing',
        ]);

        $response->assertRedirect(route('admin.donations.updates.index', $donation->id));
        $response->assertSessionHas('success', 'Update donasi berhasil ditambahkan');

        $this->assertDatabaseHas('donation_updates', [
            'donation_id' => $donation->id,
            'title' => 'New Status Update',
            'description' => 'Everything is going well.',
            'status' => 'processing',
        ]);
    }

    /**
     * Test validation rules for storing donation update.
     */
    public function test_donation_update_validation()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create();
        $donation = Donation::create([
            'name' => 'Test',
            'email' => 'test@example.com',
            'amount' => 10000,
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($admin)->post(route('admin.donations.updates.store', $donation->id), [
            'title' => '',
            'description' => '',
            'status' => '',
        ]);

        $response->assertSessionHasErrors(['title', 'description', 'status']);
        $this->assertDatabaseCount('donation_updates', 0);
    }
}
