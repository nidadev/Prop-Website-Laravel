<?php
namespace Tests\Feature;

use App\Services\DataTreeEndpoint;
use Tests\TestCase;

class DataTreeEndpointTest extends TestCase
{
    public function test_all_requests_use_the_selected_environment_and_required_version(): void
    {
        foreach (['https://dtapiuat.datatree.com/api/', 'https://dtapi.datatree.com/api'] as $base) {
            config(['property.datatree_url' => $base]);
            foreach (['Login/AuthenticateClient', 'Report/GetReport', 'Search/PropertySearch'] as $path) {
                $this->assertSame(rtrim($base, '/').'/'.$path.'?Ver=1.0', DataTreeEndpoint::url($path));
            }
        }
    }
}
