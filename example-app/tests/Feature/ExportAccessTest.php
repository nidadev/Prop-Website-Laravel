<?php

namespace Tests\Feature;

use App\Models\Export;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ExportAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_export_history_and_downloads_are_private_to_the_owner(): void
    {
        Storage::fake('local');
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $owner->forceFill(['is_subscribed' => 1, 'is_verified' => 1])->save();
        $other->forceFill(['is_subscribed' => 1, 'is_verified' => 1])->save();
        Export::create(['user_id' => $owner->id, 'file_name' => 'private-report.csv', 'status' => 'completed']);
        Storage::disk('local')->put('private-report.csv', 'PropertyId,APN');
        $this->actingAs($other)->get('/download-export/private-report.csv')->assertNotFound();
        $this->get('/exports')->assertOk()->assertDontSee('private-report.csv');
        $this->actingAs($owner)->get('/download-export/private-report.csv')->assertDownload('private-report.csv');
        $this->get('/exports')->assertOk()->assertSee('private-report.csv');
    }
}
