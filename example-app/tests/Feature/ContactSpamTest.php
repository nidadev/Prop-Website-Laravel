<?php
namespace Tests\Feature;
use App\Services\ContactSpamProtection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactSpamTest extends TestCase
{
    use RefreshDatabase;
    private function enquiry(array $changes=[]): array
    {
        $check=app(ContactSpamProtection::class)->challenge();
        $answer=json_decode(Crypt::decryptString($check['token']),true)['answer'];
        $this->travel(4)->seconds();
        return array_merge(['name'=>'Test Customer','email'=>'customer@example.com','subject'=>'Parcel question','comment'=>'Can you help me understand this parcel valuation?',
            'contact_token'=>$check['token'],'contact_answer'=>(string)$answer],$changes);
    }
    public function test_genuine_enquiry_sends_only_one_support_notification_and_cannot_be_replayed(): void
    {
        Cache::flush();Mail::shouldReceive('send')->once()->with('contactEmail',\Mockery::type('array'),\Mockery::type('Closure'));
        $data=$this->enquiry();
        $this->from('/support')->post('/support',$data)->assertRedirect('/support')->assertSessionHas('success');
        $this->from('/support')->post('/support',$data)->assertSessionHasErrors('contact_answer');
    }
    public function test_observed_spam_and_honeypot_are_discarded_without_email(): void
    {
        Mail::shouldReceive('send')->never();
        $this->post('/support',['name'=>'RobertEsove','email'=>'someone@example.com','subject'=>'Hello write about your prices','comment'=>'Spam message'])->assertSessionHas('success');
        $this->post('/support',$this->enquiry(['company_website'=>'https://spam.example']))->assertSessionHas('success');
    }
    public function test_missing_wrong_expired_and_too_fast_checks_do_not_send_mail(): void
    {
        Cache::flush();Mail::shouldReceive('send')->never();
        $this->post('/support',$this->enquiry(['contact_token'=>'tampered']))->assertSessionHasErrors('contact_answer');
        $this->post('/support',$this->enquiry(['contact_answer'=>'99']))->assertSessionHasErrors('contact_answer');
        $data=$this->enquiry();$this->travel(3)->hours();
        $this->post('/support',$data)->assertSessionHasErrors('contact_answer');
        $data=$this->enquiry();$this->travelBack();
        $this->post('/support',$data)->assertSessionHasErrors('contact_answer');
    }
    public function test_rotating_addresses_are_limited_by_ip_and_same_address_is_limited_separately(): void
    {
        Cache::flush();Mail::shouldReceive('send')->times(3);
        for($i=0;$i<3;$i++)$this->post('/support',$this->enquiry())->assertSessionHas('success');
        $this->post('/support',$this->enquiry())->assertSessionHasErrors('comment');
    }
    public function test_form_has_accessible_check_and_honeypot(): void
    {
        $this->get('/support')->assertOk()->assertSee('Quick check: what is')->assertSee('name="contact_token"',false)->assertSee('name="company_website"',false);
    }
    public function test_rotating_email_addresses_still_hit_the_ip_limit(): void
    {
        $this->withoutMiddleware(\Illuminate\Routing\Middleware\ThrottleRequests::class);
        Cache::flush();Mail::shouldReceive('send')->times(5);
        for($i=0;$i<5;$i++)$this->post('/support',$this->enquiry(['email'=>"person$i@example.com"]))->assertSessionHas('success');
        $this->post('/support',$this->enquiry(['email'=>'another@example.com']))->assertSessionHasErrors('comment');
    }
}
