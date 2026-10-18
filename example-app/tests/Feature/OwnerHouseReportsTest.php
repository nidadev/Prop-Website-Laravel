<?php
namespace Tests\Feature;

use App\Models\BillingAccount;
use App\Models\CheckoutOrder;
use App\Models\User;
use App\Services\OwnerPropertyData;
use App\Services\PropertyReportAnalysis;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class OwnerHouseReportsTest extends TestCase
{
    use RefreshDatabase;

    private function inputs(array $changes = []): array
    {
        return array_merge(['kind'=>'house','apn'=>'subject','county_fips'=>'06065','square_feet'=>1500,'lookback_days'=>90,'offer_percent'=>70,
            'latitude'=>33.9,'longitude'=>-117.4,'radius_miles'=>10,'polygon'=>[[33.8,-117.5],[34,-117.5],[34,-117.3],[33.8,-117.3]]], $changes);
    }
    private function comparable(string $apn, int $price, array $changes = []): void
    {
        DB::table('comparable_sales')->insert(array_merge(['state'=>'ca','county_fips'=>'06065','apn'=>$apn,'property_type'=>'house',
            'status'=>'sold','price'=>$price,'square_feet'=>1500,'source'=>'Synthetic QA fixture','source_url'=>'https://example.invalid/'.$apn,
            'observed_at'=>now()->toDateString(),'sold_date'=>now()->subDays(10)->toDateString(),'latitude'=>33.91,'longitude'=>-117.41,
            'address'=>'TEST FIXTURE - '.$apn,'created_at'=>now(),'updated_at'=>now()], $changes));
    }
    private function provider(): void
    {
        config(['property.datatree_enabled'=>true,'app.client_id'=>'test-client','app.client_secret'=>'test-secret']);
        Http::preventStrayRequests();
        Http::fake([
            '*Login/AuthenticateClient*'=>Http::response('"fixture-token"'),
            '*Report/GetReport*'=>fn ($r) => $r['SearchType'] === 'APN'
                ? Http::response(['Reports'=>[['PropertyId'=>123]]])
                : Http::response(['Reports'=>[['Data'=>[
                    'SubjectProperty'=>['SitusAddress'=>['APN'=>'subject','StreetAddress'=>'TEST FIXTURE - NOT A REAL PROPERTY','City'=>'QA City','State'=>'CA']],
                    'OwnerInformation'=>['Owner1FullName'=>'TEST OWNER <not real>','MailingAddress'=>['StreetAddress'=>'TEST MAILING ADDRESS']],
                    'TaxInformation'=>['AssessedValue'=>220000,'MarketLandValue'=>50000],
                ]]]]),
        ]);
    }
    public function test_analysis_deduplicates_sales_and_excludes_asking_prices_stale_wrong_type_size_and_location(): void
    {
        foreach ([300000,330000,360000] as $i=>$price) { $this->comparable('comp-'.$i,$price); }
        $this->comparable('comp-0',900000,['source'=>'Duplicate source']);
        $this->comparable('listing',900000,['status'=>'for_sale','sold_date'=>null]);
        $this->comparable('old-sale',100000,['sold_date'=>now()->subDays(150)->toDateString()]);
        $this->comparable('wrong-type',100000,['property_type'=>'land']);
        $this->comparable('wrong-size',100000,['square_feet'=>3000]);
        $this->comparable('far-away',100000,['latitude'=>40]);
        $this->comparable('no-coordinates',100000,['latitude'=>null]);
        $this->comparable('sub-ject',100000);
        $a=app(PropertyReportAnalysis::class)->analyze($this->inputs());
        $this->assertSame(3,$a['eligible_sales']);
        $this->assertSame(330000.0,$a['estimate']);
        $this->assertSame(231000.0,$a['offer']);
        $this->assertSame(1,$a['for_sale_count']);
        $this->assertCount(5,$a['records']);
        $this->assertGreaterThan(0,$a['records'][0]['distance_miles']);
        $none=app(PropertyReportAnalysis::class)->analyze($this->inputs(['polygon'=>[[34,-118],[35,-118],[35,-117],[34,-117]]]));
        $this->assertNull($none['estimate']);
        $this->assertCount(0,$none['records']);
    }
    public function test_owner_house_report_is_saved_private_paid_and_reusable_without_new_provider_calls(): void
    {
        $this->provider();
        foreach ([300000,330000,360000] as $i=>$price) { $this->comparable('comp-'.$i,$price); }
        $user=User::factory()->create(['is_verified'=>1,'is_subscribed'=>1]);
        $input=$this->inputs(); $input['polygon']=json_encode($input['polygon']);
        $this->actingAs($user)->post('/property-reports',$input)->assertRedirect('/property-reports/1');
        Http::assertSentCount(3);
        Http::assertSent(fn ($r) => ($r['ApnDetail']['CountyFips']??null) === '06065' && ($r['ApnDetail']['StateFips']??null) === '06');
        $this->get('/property-reports/1')->assertOk()->assertSee('TEST OWNER &lt;not real&gt;',false)->assertSee('330,000.00')->assertSee('Tax assessment values are not current market valuations');
        foreach (['pdf','csv','kml'] as $format) { $this->get('/property-reports/1/'.$format)->assertForbidden(); }
        $this->post('/property-reports',$input)->assertRedirect('/property-reports/1');
        Http::assertSentCount(3);
        BillingAccount::create(['user_id'=>$user->id,'plan'=>'gold','status'=>'active','period_end'=>now()->addMonth()]);
        $this->post('/stripe',['property_report_id'=>1])->assertRedirect('/property-reports/1');
        $order=CheckoutOrder::where('service','property_report')->sole();
        $this->assertSame(0,$order->amount); $this->assertSame('paid',$order->status);
        $this->post('/stripe',['property_report_id'=>1])->assertRedirect('/property-reports/1');
        $this->assertSame(1,CheckoutOrder::where('service','property_report')->count());
        $pdf=$this->get('/property-reports/1/pdf')->assertOk();
        $this->assertStringStartsWith('%PDF-',$pdf->getContent());
        if ($path=getenv('PROPELYZE_PDF_QA_PATH')) { file_put_contents($path,$pdf->getContent()); }
        $csv=$this->get('/property-reports/1/csv')->assertOk()->streamedContent();
        $this->assertStringContainsString('TEST OWNER <not real>',$csv);
        $this->assertStringContainsString('comparable,comp-0',$csv);
        $kml=$this->get('/property-reports/1/kml')->assertOk()->getContent();
        $xml=simplexml_load_string($kml); $xml->registerXPathNamespace('k','http://www.opengis.net/kml/2.2');
        $this->assertCount(4,$xml->xpath('//k:Placemark'));
        $other=User::factory()->create(['is_verified'=>1,'is_subscribed'=>1]);
        $this->actingAs($other)->get('/property-reports/1')->assertNotFound();
        $this->post('/stripe',['property_report_id'=>1])->assertNotFound();
        foreach (['pdf','csv','kml'] as $format) { $this->get('/property-reports/1/'.$format)->assertNotFound(); }
    }
    public function test_disabled_and_failed_provider_do_not_create_reports_or_charge_and_invalid_geometry_is_rejected(): void
    {
        $user=User::factory()->create(['is_verified'=>1,'is_subscribed'=>1]);
        $this->actingAs($user); $this->withoutMiddleware(\Illuminate\Routing\Middleware\ThrottleRequests::class); Http::preventStrayRequests();
        config(['property.datatree_enabled'=>false]);
        $input=$this->inputs();$input['polygon']=json_encode($input['polygon']);
        $this->post('/property-reports',$input)->assertSessionHas('error');
        Http::assertNothingSent();
        $this->assertDatabaseCount('property_report_snapshots',0);$this->assertDatabaseCount('checkout_orders',0);
        $this->postJson('/property-reports',array_merge($input,['polygon'=>'[[33,-118],[34,-117],[33,-117],[34,-118]]']))->assertUnprocessable();
        $this->postJson('/property-reports',array_merge($input,['latitude'=>null]))->assertUnprocessable();
        config(['property.datatree_enabled'=>true,'app.client_id'=>'test-client','app.client_secret'=>'test-secret']); Http::fake(['*'=>Http::response(['error'=>'unauthorized'],401)]);
        $this->post('/property-reports',$input)->assertSessionHas('error');
        $this->assertDatabaseCount('property_report_snapshots',0);$this->assertDatabaseCount('checkout_orders',0);
    }
    public function test_provider_does_not_return_wrong_parcel_or_fabricate_missing_owner_tax_fields(): void
    {
        $this->provider();
        $s=app(OwnerPropertyData::class)->fetch('subject','06065');
        $this->assertNull($s['owner_2']); $this->assertNull($s['tax_market_value']);
        $this->assertSame('220000',$s['assessed_value']);
        $this->expectException(\RuntimeException::class);
        app(OwnerPropertyData::class)->fetch('different','06065');
    }
    public function test_report_credits_are_shared_with_land_and_comp_reports(): void
    {
        config(['pricing.plans.gold.reports'=>1]);
        $user=User::factory()->create();
        BillingAccount::create(['user_id'=>$user->id,'plan'=>'gold','status'=>'active','period_end'=>now()->addMonth()]);
        $allowance=app(\App\Services\ReportAllowance::class);
        $this->assertNotNull($allowance->claim($user->id,['1'],'property_report'));
        $this->assertNull($allowance->claim($user->id,['2'],'land_report'));
        $this->assertNull($allowance->claim($user->id,['3'],'comp_report'));
        $this->assertNotNull($allowance->claim($user->id,['1'],'property_report'));
        $this->assertSame(1,CheckoutOrder::where('user_id',$user->id)->count());
    }
}
