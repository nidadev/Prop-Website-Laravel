<?php

namespace Tests\Feature;

use App\Jobs\FetchPriceReportJob;
use App\Models\PriceReport;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class ReportResultsTest extends TestCase
{
    use RefreshDatabase;

    public function test_failed_provider_search_stops_polling_without_exposing_exception(): void
    {
        Queue::fake();
        $owner = User::factory()->create(['is_verified' => 1, 'is_subscribed' => 1]);
        $this->actingAs($owner)->post('/priceland', ['state' => 'ca', 'county_name' => 'Riverside', 'cp' => '06065']);
        (new FetchPriceReportJob('ca', 'Riverside', '06065', $owner->id))->failed(new \RuntimeException('secret provider detail'));
        $this->get(route('get.report.results'))->assertOk()->assertHeaderMissing('Refresh')
            ->assertSee('could not complete')->assertDontSee('secret provider detail');
    }

    public function test_county_from_another_state_cannot_be_queued(): void
    {
        Queue::fake();
        $owner = User::factory()->create(['is_verified' => 1, 'is_subscribed' => 1]);
        $this->actingAs($owner)->post('/priceland', ['state' => 'ca', 'county_name' => 'Riverside', 'cp' => '21065'])
            ->assertSessionHasErrors('cp');
        Queue::assertNothingPushed();
    }

    public function test_pending_report_can_be_retrieved_after_the_queue_finishes_and_remains_private(): void
    {
        Queue::fake();
        $owner = User::factory()->create(['is_verified' => 1, 'is_subscribed' => 1]);
        $this->actingAs($owner)->post('/priceland', ['state' => 'ca', 'county_name' => 'Riverside', 'cp' => '06065'])
            ->assertRedirect(route('get.report.results'));
        Queue::assertPushed(FetchPriceReportJob::class);
        $this->get(route('get.report.results'))->assertOk()->assertHeader('Refresh', '10')->assertSee('being generated');
        $report = PriceReport::create(['user_id' => $owner->id, 'state' => 'ca', 'county_name' => 'Riverside', 'sts' => '[]', 'de' => '[]', 'price' => '[]']);
        $this->get(route('get.report.results'))->assertOk()->assertHeaderMissing('Refresh');
        $this->actingAs(User::factory()->create(['is_verified' => 1, 'is_subscribed' => 1]))
            ->get(route('get.report.results', ['report_id' => $report->id]))->assertNotFound();
    }
}
