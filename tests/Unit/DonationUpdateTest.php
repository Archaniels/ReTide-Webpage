<?php

namespace Tests\Unit;

use App\Models\Donation;
use App\Models\DonationUpdate;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DonationUpdateTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the DonationUpdate model's fillable properties.
     */
    public function test_donation_update_fillable_attributes(): void
    {
        $update = new DonationUpdate;

        $this->assertEquals([
            'donation_id',
            'title',
            'description',
            'status',
        ], $update->getFillable());
    }

    /**
     * Test that we can create a DonationUpdate and persist it.
     */
    public function test_can_create_donation_update(): void
    {
        $user = User::factory()->create();
        $donation = Donation::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'amount' => 50000,
            'user_id' => $user->id,
        ]);

        $updateData = [
            'donation_id' => $donation->id,
            'title' => 'Project Started',
            'description' => 'We have officially started the project.',
            'status' => 'in_progress',
        ];

        $update = DonationUpdate::create($updateData);

        $this->assertInstanceOf(DonationUpdate::class, $update);
        $this->assertDatabaseHas('donation_updates', $updateData);
        $this->assertEquals('Project Started', $update->title);
    }

    /**
     * Test donation update belongs to a donation.
     */
    public function test_donation_update_belongs_to_donation(): void
    {
        $user = User::factory()->create();
        $donation = Donation::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'amount' => 50000,
            'user_id' => $user->id,
        ]);

        $update = DonationUpdate::create([
            'donation_id' => $donation->id,
            'title' => 'Project Started',
            'description' => 'We have officially started the project.',
            'status' => 'in_progress',
        ]);

        $this->assertInstanceOf(Donation::class, $update->donation);
        $this->assertEquals($donation->id, $update->donation->id);
    }
}
