<?php

namespace Tests\Feature;

use App\Jobs\FetchPriceReportJob;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class SavedSearchTest extends TestCase
{
    use RefreshDatabase;
    public function test_saved_searches_can_be_rerun_removed_and_restored_only_by_the_owner(): void
    {
        Queue::fake();
        $owner = User::factory()->create(['is_verified' => 1, 'is_subscribed' => 1]);
        $this->actingAs($owner)->post('/saved-searches', ['kind' => 'land', 'state' => 'ca', 'county_name' => 'Riverside', 'cp' => '06065'])->assertRedirect('/saved-searches');
        $this->get('/saved-searches')->assertOk()->assertSee('Riverside, CA');
        $this->post('/saved-searches/1/run')->assertRedirect(route('get.report.results'));
        Queue::assertPushed(FetchPriceReportJob::class);
        $this->post('/saved-searches/1/remove')->assertRedirect();
        $this->get('/saved-searches')->assertDontSee('Riverside, CA');
        $this->post('/saved-searches/1/restore')->assertRedirect('/saved-searches');
        $this->get('/saved-searches')->assertSee('Riverside, CA');
        $this->actingAs(User::factory()->create(['is_verified' => 1, 'is_subscribed' => 1]));
        $this->post('/saved-searches/1/run')->assertNotFound();
        $this->post('/saved-searches/1/remove')->assertNotFound();
        $this->post('/saved-searches/1/restore')->assertNotFound();
    }
}
