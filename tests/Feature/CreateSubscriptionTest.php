<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use App\Models\Topic;

class CreateSubscriptionTest extends TestCase
{
    use RefreshDatabase;

    public function test_that_missing_url_field_returns_error()
    {
        $topic = $this->generate_topic();
        $response = $this->postJson('/api/v1/subscribe/'.$topic->value, []);
        $response
            ->assertStatus(400)
            ->assertJson([
                'error' => 'invalid_input',
            ]);
    }

    public function test_that_invalid_url_field_returns_error()
    {
        $topic = $this->generate_topic();
        $response = $this->postJson('/api/v1/subscribe/'.$topic->value, [
            'url' => "testing"
        ]);
        $response
            ->assertStatus(400)
            ->assertJson([
                'error' => 'invalid_input',
            ]);
    }

    public function test_that_invalid_topic_params_returns_error()
    {
        $response = $this->postJson('/api/v1/subscribe/hh', [
            'url' => "testing"
        ]);
        $response
            ->assertStatus(400)
            ->assertJson([
                'error' => 'invalid_input',
            ]);
    }

    public function test_that_subscription_gets_created()
    {
        $topic = $this->generate_topic();
        $response = $this->postJson('/api/v1/subscribe/'.$topic->value, [
            'url' => "https://test.com"
        ]);
        $this->assertDatabaseHas('subscriptions', [
            'url' => 'https://test.com',
            'topic_id' => $topic->id
        ]);
    }

    public function test_that_subscription_endpoint_returns_success_response()
    {
        $topic = $this->generate_topic();
        $response = $this->postJson('/api/v1/subscribe/'.$topic->value, [
            'url' => "https://test.com"
        ]);
        $response
            ->assertStatus(200)
            ->assertJson([
                'url' => 'https://test.com',
                'topic' => $topic->value
            ]);
    }

    protected function generate_topic()
    {
        return Topic::create([
            'value' => "test"
        ]);
    }
}
