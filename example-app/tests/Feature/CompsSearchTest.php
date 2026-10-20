<?php
namespace Tests\Feature;
use App\Models\BillingAccount;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;
class CompsSearchTest extends TestCase {
    use RefreshDatabase;
    public function test_comps_are_private_and_csv_requires_an_export_plan(): void {
        config(['prycd.enabled'=>true,'prycd.key'=>'fake']);
        Http::fake(['*'=>Http::response(['status'=>200,'data'=>[['comps'=>[['comps'=>[['price'=>30000,'acreage'=>3,'status'=>'Sold','address'=>'Example parcel','url'=>'https://www.redfin.com/example','source'=>'Redfin']]]]]]])]);
        $user=User::factory()->create(['is_verified'=>1,'is_subscribed'=>1]);
        $this->actingAs($user)->post('/land-comps',['state'=>'Washington','county'=>'King','min_acres'=>2,'max_acres'=>4])->assertRedirect('/land-comps/1');
        $this->get('/land-comps/1')->assertOk()->assertSee('30,000.00')->assertSee('OpenStreetMap');
        $this->get('/land-comps/1/download')->assertForbidden();
        BillingAccount::create(['user_id'=>$user->id,'plan'=>'bronze_plus','status'=>'active','period_end'=>now()->addMonth()]);
        $this->get('/land-comps/1/download')->assertDownload('propelyze-land-comps-1.csv');
        $this->actingAs(User::factory()->create(['is_verified'=>1,'is_subscribed'=>1]))->get('/land-comps/1')->assertNotFound();
    }
}
