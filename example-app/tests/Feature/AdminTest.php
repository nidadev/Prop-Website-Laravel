<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_manage_users_and_settings_and_suspensions_block_existing_sessions(): void
    {
        $admin = User::factory()->create(['usertype' => 'admin']);
        $user = User::factory()->create(['is_verified' => 1, 'is_subscribed' => 1]);
        $this->actingAs($user)->get('/adminpage')->assertForbidden();
        $this->actingAs($admin)->get('/adminpage')->assertOk()->assertSee('Registered users');
        $this->post('/admin/users/'.$user->id, ['name' => 'Updated', 'email' => $user->email, 'is_banned' => 1])->assertRedirect();
        $this->actingAs($user->fresh())->get('/profile')->assertForbidden();
        $this->get('/exports')->assertForbidden();
        $this->actingAs($admin)->post('/admin/users/'.$admin->id, ['name' => $admin->name, 'email' => $admin->email, 'is_banned' => 1])->assertUnprocessable();
        $this->post('/admin/settings', ['seo_title' => '<script>alert(1)</script>', 'contact_email' => 'hello@example.com'])->assertRedirect();
        $this->get('/home')->assertOk()->assertSee('&lt;script&gt;alert(1)&lt;/script&gt;', false)->assertDontSee('<title><script>', false);
        $this->get('/support')->assertOk()->assertSee('hello@example.com');
    }

    public function test_settings_cannot_embed_an_arbitrary_remote_site(): void
    {
        $this->actingAs(User::factory()->create(['usertype' => 'admin']))
            ->post('/admin/settings', ['map_embed_url' => 'https://example.com/maps'])->assertUnprocessable();
        $this->assertDatabaseCount('site_settings', 0);
    }
}
