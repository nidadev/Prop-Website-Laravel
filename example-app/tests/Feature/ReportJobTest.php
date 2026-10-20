<?php

namespace Tests\Feature;

use App\Jobs\FetchPriceReportJob;
use App\Jobs\FetchPriceHouseReportJob;
use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ReportJobTest extends TestCase
{
    use RefreshDatabase;

    public function test_empty_provider_results_save_to_the_correct_owner_without_phantom_properties(): void
    {
        $owner = User::factory()->create();
        foreach ([FetchPriceReportJob::class => 'price_reports', FetchPriceHouseReportJob::class => 'price_house_reports'] as $job => $table) {
            $history = [];
            $responses = [new Response(200, [], '"token"')];
            for ($i = 0; $i < 20; $i++) { $responses[] = new Response(200, [], '{"LitePropertyList":[]}'); }
            $stack = HandlerStack::create(new MockHandler($responses));
            $stack->push(Middleware::history($history));
            (new $job('ca', 'Riverside', '06065', $owner->id))->handle(new Client(['handler' => $stack]));
            $this->assertDatabaseHas($table, ['user_id' => $owner->id, 'state' => 'ca']);
            $report = DB::table($table)->first();
            foreach (json_decode($report->sts, true) as $group) { $this->assertSame([], $group['prop']); }
            $request = json_decode((string) $history[1]['request']->getBody(), true);
            $filters = array_column($request['SearchRequest']['Filters'], 'FilterValues', 'FilterName');
            $this->assertSame(['65'], $filters['CountyFips']);
            $this->assertSame([6], $filters['StateFips']);
        }
    }
}
