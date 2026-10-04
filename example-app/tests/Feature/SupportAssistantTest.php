<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class SupportAssistantTest extends TestCase
{
    use RefreshDatabase;
    public function test_assistant_requires_consent_and_only_sends_the_question_with_public_help_content(): void
    {
        config(['services.support_ai.enabled' => true, 'services.support_ai.key' => 'private-test-key']);
        Http::fake(['api.openai.com/*' => Http::response(['status' => 'completed', 'output' => [[
            'type' => 'message', 'content' => [['type' => 'output_text', 'text' => 'Use Forgot Password to reset your password.']],
        ]]])]);
        $this->postJson('/support/assistant', ['message' => 'How do I reset my password?'])->assertUnprocessable();
        Http::assertNothingSent();
        $this->postJson('/support/assistant', ['message' => 'How do I reset my password?', 'consent' => true])
            ->assertOk()->assertJsonPath('message', 'Use Forgot Password to reset your password.');
        Http::assertSent(fn ($request) => $request['store'] === false && $request['max_output_tokens'] === 300
            && $request['input'] === 'How do I reset my password?' && !isset($request['tools']));
        $this->get('/support')->assertDontSee('private-test-key');
    }
    public function test_disabled_or_failed_ai_returns_human_support_without_inventing_an_answer(): void
    {
        Http::fake(); config(['services.support_ai.enabled' => false]);
        $this->postJson('/support/assistant', ['message' => 'Question', 'consent' => true])->assertStatus(503);
        Http::assertNothingSent();
        config(['services.support_ai.enabled' => true, 'services.support_ai.key' => 'test-key']);
        Http::fake(['*' => Http::response([], 500)]);
        $this->postJson('/support/assistant', ['message' => 'Question', 'consent' => true])->assertStatus(503)->assertJsonPath('message', 'The assistant could not answer right now. Please contact support.');
    }
}
