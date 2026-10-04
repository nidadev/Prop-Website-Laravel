<?php
namespace Tests\Feature;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
class RegistrationCaptchaTest extends TestCase {
    use RefreshDatabase;
    public function test_a_successful_captcha_for_another_hostname_cannot_register_an_account(): void {
        config(['services.recaptcha.enabled'=>true,'services.recaptcha.site_key'=>'public-test','services.recaptcha.secret'=>'secret-test','app.url'=>'https://propelyze.com']);
        Http::fake(['*'=>Http::response(['success'=>true,'hostname'=>'another.example'])]); Mail::fake();
        $this->postJson('/api/register',['name'=>'Test Account','email'=>'test@example.test','password'=>'password123','password_confirmation'=>'password123','agree'=>true,'g-recaptcha-response'=>'test-response'])
            ->assertUnprocessable()->assertJsonValidationErrors('captcha');
        $this->assertDatabaseCount('users',0);
    }
    public function test_valid_captcha_creates_an_unverified_account_and_a_hashed_expiring_verification_token(): void {
        config(['services.recaptcha.enabled'=>true,'services.recaptcha.site_key'=>'public-test','services.recaptcha.secret'=>'secret-test','app.url'=>'https://propelyze.com']);
        Http::fake(['*'=>Http::response(['success'=>true,'hostname'=>'propelyze.com'])]); Mail::fake();
        $this->postJson('/api/register',['name'=>'Test Account','email'=>'test@example.test','password'=>'password123','password_confirmation'=>'password123','agree'=>true,'g-recaptcha-response'=>'test-response'])->assertCreated();
        $this->assertDatabaseHas('users',['email'=>'test@example.test','is_verified'=>0]);
        $this->assertDatabaseCount('email_verification_tokens',1);
        $this->assertEquals(64,strlen(\Illuminate\Support\Facades\DB::table('email_verification_tokens')->value('token_hash')));
    }
}
