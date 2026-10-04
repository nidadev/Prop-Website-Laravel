<?php
namespace Tests\Feature;
use App\Models\User;
use App\Services\EmailVerification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
class VerificationAndTokenTest extends TestCase {
    use RefreshDatabase;
    private function token(User $user): string {
        $token = str_repeat('a', 64);
        DB::table('email_verification_tokens')->insert(['user_id' => $user->id, 'email' => $user->email,
            'token_hash' => hash('sha256', $token), 'expires_at' => now()->addHour(), 'created_at' => now(), 'updated_at' => now()]);
        return $token;
    }
    public function test_verification_is_single_use_and_does_not_change_the_remember_token(): void {
        $user = User::factory()->create(['remember_token' => 'remember']);
        $token = $this->token($user);
        $this->get('/verify-mail/'.$token)->assertRedirect('/login');
        $this->assertEquals(1, $user->fresh()->is_verified);
        $this->assertSame('remember', $user->fresh()->remember_token);
        $this->get('/verify-mail/'.$token)->assertNotFound();
    }
    public function test_expired_or_previous_email_verification_cannot_verify_the_account(): void {
        $user = User::factory()->create(['is_verified' => 0]);
        $token = $this->token($user);
        $user->update(['email' => 'changed@example.test']);
        $this->get('/verify-mail/'.$token)->assertNotFound();
        $user->update(['email' => DB::table('email_verification_tokens')->value('email')]);
        $this->travel(61)->minutes();
        $this->get('/verify-mail/'.$token)->assertNotFound();
        $this->assertEquals(0, $user->fresh()->is_verified);
    }
    public function test_registration_requires_consent_and_password_confirmation(): void {
        Mail::fake();
        $this->postJson('/api/register', ['name' => 'Example User', 'email' => 'example@example.test',
            'password' => 'password123', 'password_confirmation' => 'different', 'agree' => false])
            ->assertUnprocessable()->assertJsonValidationErrors(['password', 'agree']);
        $this->assertDatabaseCount('users', 0);
    }
    public function test_api_profile_requires_a_token_and_revocation_prevents_reuse(): void {
        $user = User::factory()->create(['password' => 'password123']);
        $this->getJson('/api/profile')->assertUnauthorized();
        $token = $this->postJson('/api/login', ['email' => $user->email, 'password' => 'password123'])->assertOk()->json('token');
        $this->withToken($token)->getJson('/api/profile')->assertOk()->assertJsonPath('user_id', $user->id);
        $this->withToken($token)->postJson('/api/logout')->assertOk();
        // Reset the resolved guard between requests, as a new HTTP request would do.
        $this->app['auth']->forgetGuards();
        $this->withToken($token)->getJson('/api/profile')->assertUnauthorized();
    }
    public function test_suspended_users_cannot_sign_in(): void {
        $user = User::factory()->create(['password' => 'password123', 'is_banned' => true]);
        $this->postJson('/api/login', ['email' => $user->email, 'password' => 'password123'])->assertUnauthorized();
    }
    public function test_unverified_user_can_sign_in_to_resend_verification_but_cannot_access_paid_services(): void {
        $user = User::factory()->create(['password' => 'password123', 'is_verified' => 0]);
        $this->post('/login', ['email' => $user->email, 'password' => 'password123'])->assertRedirect('/profile');
        $this->assertAuthenticatedAs($user);
        $this->get('/compreport')->assertRedirect('/profile');
    }
}
