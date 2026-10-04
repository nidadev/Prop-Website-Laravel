<?php
namespace Tests\Feature;
use App\Models\User;
use App\Models\CheckoutOrder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Tests\TestCase;
class LandValuationTest extends TestCase {
    use RefreshDatabase;
    public function test_saved_land_value_is_private_and_pdf_requires_purchase(): void {
        config(['prycd.enabled' => true, 'prycd.key' => 'fake']);
        Http::fake(['*' => Http::response(['status' => 200, 'apn' => '00123', 'pricing' => ['price' => 12300, 'price_per_acre' => 1230]], 200)]);
        $user = User::factory()->create(['is_verified' => 1, 'is_subscribed' => 1]);
        $this->actingAs($user)->post('/land-valuation', ['apn' => '00123', 'county_fips' => '06065'])->assertRedirect('/land-valuation/1');
        $this->post('/land-valuation', ['apn' => '00123', 'county_fips' => '06065'])->assertRedirect('/land-valuation/1');
        Http::assertSentCount(1);
        $this->get('/land-valuation/1')->assertOk()->assertSee('12,300.00');
        $this->get('/land-valuation/1/pdf')->assertForbidden();
        CheckoutOrder::create(['id' => (string) Str::uuid(), 'user_id' => $user->id, 'service' => 'land_report', 'property_ids' => ['1'], 'amount' => 200, 'status' => 'paid']);
        $this->get('/land-valuation/1/pdf')->assertOk()->assertHeader('Content-Type', 'application/pdf');
        $this->actingAs(User::factory()->create(['is_verified' => 1, 'is_subscribed' => 1]))->get('/land-valuation/1')->assertNotFound();
    }
}
