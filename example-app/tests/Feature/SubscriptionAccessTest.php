<?php

namespace Tests\Feature;

use App\Models\BillingAccount;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubscriptionAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_email_verification_and_current_membership_are_required_for_property_services(): void
    {
        $user = User::factory()->create(['is_subscribed' => 1, 'is_verified' => 0]);
        $this->actingAs($user)->get('/exports')->assertRedirect('/profile');
        $user->forceFill(['is_verified' => 1])->save();
        BillingAccount::create(['user_id' => $user->id, 'plan' => 'bronze', 'status' => 'active', 'period_end' => now()->subDay()]);
        $this->get('/exports')->assertRedirect('/subscription');
        BillingAccount::where('user_id', $user->id)->update(['period_end' => now()->addDay()]);
        $this->get('/exports')->assertOk();
    }
}
