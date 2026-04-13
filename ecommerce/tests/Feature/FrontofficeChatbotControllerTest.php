<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class FrontofficeChatbotControllerTest extends TestCase
{
    public function test_it_sends_message_to_groq_and_returns_reply(): void
    {
        config()->set('services.groq.api_key', 'test-key');

        Http::fake([
            'api.groq.com/*' => Http::response([
                'choices' => [
                    ['message' => ['content' => '  Hello from Groq  ']],
                ],
            ], 200),
        ]);

        $response = $this->postJson(route('frontoffice.chatbot'), [
            'message' => 'What can I buy here?',
            'history' => [
                ['role' => 'assistant', 'content' => 'Hi!'],
                ['role' => 'user', 'content' => 'What can I buy here?'],
            ],
        ]);

        $response
            ->assertOk()
            ->assertJson([
                'reply' => 'Hello from Groq',
            ]);

        Http::assertSent(function ($request) {
            $payload = $request->data();
            $messages = $payload['messages'];

            $this->assertSame('system', $messages[0]['role']);
            $this->assertSame('assistant', $messages[1]['role']);
            $this->assertSame('user', $messages[2]['role']);
            $this->assertSame('What can I buy here?', $messages[2]['content']);
            $this->assertCount(3, $messages);

            return true;
        });
    }

    public function test_it_returns_503_when_api_key_is_missing(): void
    {
        config()->set('services.groq.api_key', null);

        $response = $this->postJson(route('frontoffice.chatbot'), [
            'message' => 'Hello?',
        ]);

        $response
            ->assertStatus(503)
            ->assertJson([
                'message' => 'Groq API key is not configured on the server.',
            ]);
    }
}
