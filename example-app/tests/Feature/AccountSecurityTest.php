<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class AccountSecurityTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_updates_cannot_target_another_user_id(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $original = $other->name;
        $this->actingAs($owner)->post('/profile-update', ['id' => $other->id, 'name' => 'Updated Name', 'email' => $owner->email])->assertRedirect();
        $this->assertSame('Updated Name', $owner->fresh()->name);
        $this->assertSame($original, $other->fresh()->name);
    }

    public function test_unknown_email_returns_a_generic_login_error(): void
    {
        $this->from('/login')->post('/login', ['email' => 'missing@example.test', 'password' => 'password123'])
            ->assertRedirect('/login')->assertSessionHas('error');
    }

    public function test_password_cannot_be_reset_by_submitting_a_user_id(): void
    {
        $user = User::factory()->create();
        $original = $user->password;
        $this->post('/reset', ['id' => $user->id, 'password' => 'replacement123', 'password_confirmation' => 'replacement123'])
            ->assertSessionHasErrors(['email', 'token']);
        $this->assertSame($original, $user->fresh()->password);
    }

    public function test_a_reset_token_is_bound_to_its_email_and_consumed_once(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $token = Password::createToken($owner);
        $payload = ['token' => $token, 'password' => 'replacement123', 'password_confirmation' => 'replacement123'];
        $this->post('/reset', $payload + ['email' => $other->email])->assertSessionHas('error');
        $this->assertFalse(Hash::check('replacement123', $other->fresh()->password));
        $this->post('/reset', $payload + ['email' => $owner->email])->assertRedirect('/login');
        $this->assertTrue(Hash::check('replacement123', $owner->fresh()->password));
        $this->post('/reset', $payload + ['email' => $owner->email])->assertSessionHas('error');
    }

    public function test_an_expired_reset_token_cannot_change_a_password(): void
    {
        $user = User::factory()->create();
        $token = Password::createToken($user);
        $this->travel(61)->minutes();
        $this->post('/reset', ['email' => $user->email, 'token' => $token, 'password' => 'replacement123', 'password_confirmation' => 'replacement123'])
            ->assertSessionHas('error');
        $this->assertFalse(Hash::check('replacement123', $user->fresh()->password));
    }
}
