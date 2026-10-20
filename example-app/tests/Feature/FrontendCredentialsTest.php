<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FrontendCredentialsTest extends TestCase
{
    use RefreshDatabase;
    public function test_provider_credentials_are_not_rendered_and_jquery_is_loaded_once(): void
    {
        config(['app.client_id' => 'private-client-id', 'app.client_secret' => 'private-client-secret']);
        $response = $this->get('/home')->assertOk()->assertDontSee('private-client-secret')->assertDontSee('private-client-id')->assertDontSee('ClientSecretKey');
        $this->assertSame(1, substr_count($response->getContent(), 'jquery-3.7.1.min.js'));
    }
}
