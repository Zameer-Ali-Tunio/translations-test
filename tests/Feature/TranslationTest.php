<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TranslationTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_translation(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/translations', [
            'key' => 'greeting',
            'translations' => [
                'en' => 'Hello',
                'fr' => 'Bonjour',
            ],
        ]);

        $response->assertStatus(201)
                 ->assertJsonFragment(['key' => 'greeting']);

        $this->assertDatabaseHas('translations', ['key' => 'greeting']);
    }

    public function test_guest_cannot_create_translation(): void
    {
        $response = $this->postJson('/api/translations', [
            'key' => 'unauth',
            'translations' => ['en' => 'Fail'],
        ]);

        $response->assertStatus(401);
    }
}
