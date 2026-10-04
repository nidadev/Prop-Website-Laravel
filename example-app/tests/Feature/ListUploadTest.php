<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ListUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_upload_preserves_apns_deduplicates_and_is_private(): void
    {
        $owner = User::factory()->create(['is_verified' => 1, 'is_subscribed' => 1]);
        $file = UploadedFile::fake()->createWithContent('parcels.csv', "state,county_fips,apn\nca,06065,00123\nca,06065,00123\n");
        $this->actingAs($owner)->post('/list-upload', ['file' => $file])->assertRedirect('/list-upload/1');
        $this->assertDatabaseHas('list_uploads', ['user_id' => $owner->id, 'record_count' => 1]);
        $this->assertDatabaseHas('list_upload_rows', ['apn' => '00123', 'county_fips' => '06065']);
        $this->get('/list-upload/1')->assertOk()->assertSee('00123');
        $this->actingAs(User::factory()->create())->get('/list-upload/1')->assertNotFound();
    }

    public function test_invalid_county_or_duplicate_headers_do_not_create_uploads(): void
    {
        $this->actingAs(User::factory()->create(['is_verified' => 1, 'is_subscribed' => 1]));
        foreach (["state,county_fips,apn\nca,48001,123\n", "state,county_fips,apn,apn\nca,06065,123,123\n"] as $contents) {
            $this->post('/list-upload', ['file' => UploadedFile::fake()->createWithContent('parcels.csv', $contents)])
                ->assertSessionHasErrors('file');
        }
        $this->assertDatabaseCount('list_uploads', 0);
    }
}
