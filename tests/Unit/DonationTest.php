<?php

namespace Tests\Unit;

use App\Models\Donation;
use App\Models\DonationUpdate;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DonationTest extends TestCase
{
    use RefreshDatabase;

    public function test_donation_fillable_attributes(): void
    {
        $donation = new Donation;

        $this->assertEquals([
            'name',
            'email',
            'amount',
            'message',
            'user_id',
        ], $donation->getFillable());
    }

    public function test_can_create_donation(): void
    {
        $user = User::factory()->create();

        $donationData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'amount' => 50000,
            'message' => 'Keep up the good work!',
            'user_id' => $user->id,
        ];

        $donation = Donation::create($donationData);

        $this->assertInstanceOf(Donation::class, $donation);
        $this->assertDatabaseHas('donations', $donationData);
        $this->assertEquals('John Doe', $donation->name);
        $this->assertEquals(50000, $donation->amount);
    }

    public function test_donation_belongs_to_user(): void
    {
        $user = User::factory()->create();
        $donation = Donation::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'amount' => 10000,
            'user_id' => $user->id,
        ]);

        $this->assertInstanceOf(User::class, $donation->user);
        $this->assertEquals($user->id, $donation->user->id);
    }

    public function test_donation_has_many_updates(): void
    {
        $user = User::factory()->create();
        $donation = Donation::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'amount' => 10000,
            'user_id' => $user->id,
        ]);

        DonationUpdate::create([
            'donation_id' => $donation->id,
            'title' => 'Update 1',
            'description' => 'Description 1',
            'status' => 'pending',
        ]);

        DonationUpdate::create([
            'donation_id' => $donation->id,
            'title' => 'Update 2',
            'description' => 'Description 2',
            'status' => 'completed',
        ]);

        $this->assertCount(2, $donation->updates);
        $this->assertInstanceOf(DonationUpdate::class, $donation->updates->first());
    }
}
