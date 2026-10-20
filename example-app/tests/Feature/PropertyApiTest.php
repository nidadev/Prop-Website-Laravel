<?php
namespace Tests\Feature;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;
class PropertyApiTest extends TestCase {
    use RefreshDatabase;
    public function test_api_requires_subscription_verification_and_property_scope(): void {
        config(['prycd.enabled'=>true,'prycd.key'=>'fake']);
        Http::fake(['*'=>Http::response(['status'=>200,'apn'=>'001','pricing'=>['price'=>12345]],200)]);
        $user=User::factory()->create(['is_verified'=>1,'is_subscribed'=>1]);
        $token=$user->createToken('test',['property:read'])->plainTextToken;
        $this->withToken($token)->postJson('/api/land/price',['apn'=>'001','county_fips'=>'06065'])->assertOk()->assertJsonPath('data.market_value',12345);
        $user->forceFill(['is_verified'=>0])->save();
        \Illuminate\Support\Facades\Auth::forgetGuards();
        $this->withToken($token)->postJson('/api/land/price',['apn'=>'001','county_fips'=>'06065'])->assertForbidden();
        $user->forceFill(['is_verified'=>1,'is_subscribed'=>0])->save();
        \Illuminate\Support\Facades\Auth::forgetGuards();
        $this->withToken($token)->postJson('/api/land/price',['apn'=>'001','county_fips'=>'06065'])->assertForbidden();
        Http::assertSentCount(1);
    }
}
