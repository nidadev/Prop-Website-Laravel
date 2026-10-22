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
    public function test_v3_requires_expected_action_score_and_hostname(): void {
        config(['services.recaptcha.enabled'=>true,'services.recaptcha.site_key'=>'public-test','services.recaptcha.secret'=>'secret-test',
            'services.recaptcha.type'=>'v3','services.recaptcha.minimum_score'=>0.5,'app.url'=>'https://propelyze.com']);
        $response=['success'=>true,'hostname'=>'propelyze.com','action'=>'register','score'=>0.9];
        Http::fake(fn()=>Http::response($response));
        $request=\Illuminate\Http\Request::create('/register','POST',['g-recaptcha-response'=>'test-response']);
        app(\App\Services\RegistrationCaptcha::class)->verify($request);
        $this->addToAssertionCount(1);
        foreach ([['score'=>0.1],['score'=>null],['score'=>2],['action'=>'login'],['hostname'=>'wrong.example'],['success'=>false]] as $change) {
            Http::swap(new \Illuminate\Http\Client\Factory());
            Http::fake(fn()=>Http::response(array_merge($response,$change)));
            try { app(\App\Services\RegistrationCaptcha::class)->verify($request); $this->fail('Invalid v3 response accepted'); }
            catch (\Illuminate\Validation\ValidationException $e) { $this->assertArrayHasKey('captcha',$e->errors()); }
        }
    }
    public function test_v3_page_requests_a_fresh_registration_action_token_without_a_v2_checkbox(): void {
        config(['services.recaptcha.enabled'=>true,'services.recaptcha.site_key'=>'public-test','services.recaptcha.type'=>'v3']);
        $this->get('/register')->assertOk()->assertSee('recaptcha/api.js?render=public-test',false)
            ->assertSee("{action:'register'}",false)->assertSee('registration-captcha-token')->assertDontSee('class="g-recaptcha mb-3"',false);
    }
}
