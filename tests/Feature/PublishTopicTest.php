<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use App\Models\Topic;
use Illuminate\Support\Facades\Event;
use App\Events\MessagePublished;

class PublishTopicTest extends TestCase
{
    use RefreshDatabase;

    public function test_that_missing_body_returns_error()
    {
        $topic = $this->generate_topic();
        $response = $this->postJson('/api/v1/publish/'.$topic->value, []);
        $response
            ->assertStatus(400)
            ->assertJson([
                'error' => 'invalid_input',
            ]);
    }

    public function test_that_invalid_topic_params_returns_error()
    {
        $response = $this->postJson('/api/v1/publish/hh', [
            'msg' => "hello"
        ]);
        $response
            ->assertStatus(400)
            ->assertJson([
                'error' => 'invalid_input',
            ]);
    }

    public function test_that_publish_endpoint_returns_success_response()
    {
        Event::fake();

        $topic = $this->generate_topic();
        $response = $this->postJson('/api/v1/publish/'.$topic->value, [
            'msg' => "hello"
        ]);

        Event::assertDispatched(MessagePublished::class);
        $response->assertStatus(200);
    }

    protected function generate_topic()
    {
        return Topic::create([
            'value' => "test"
        ]);
    }
}
