<?php

namespace Tests\Feature;

use App\Http\Resources\BoardgameResource;
use App\Models\Publisher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Utils\DefaultUserTestTrait;

class BoardgameTest extends TestCase
{
    use DefaultUserTestTrait;

    const BOARDGAMES_URL = '/api/boardgames';

    public function test_boardgame_creation_failed_for_no_auth_token_request(): void
    {
        $response = $this
            ->withHeader('Accept', 'application/json')
            ->post(
                self::BOARDGAMES_URL,
                [
                    'name' => 'Test Boardgame',
                    'description' => 'This is a test boardgame.',
                    'number_of_players' => 1,
                    'playtime' => 60,
                ]
            );

        $response->assertStatus(401);

        $response->assertJson([
            'message' => 'Unauthenticated.',
        ]);
    }

    public function test_boardgame_creation_failed_for_invalid_body(): void
    {
        $response = $this
            ->withHeader('Accept', 'application/json')
            ->withHeader('Authorization', 'Bearer ' . $this->getDefaultUserToken())
            ->post(
                self::BOARDGAMES_URL,
                [
                    'name' => '',
                    'publisher_id' => -1,
                    'number_of_players' => -1,
                    'playtime' => -1,
                ]
            );

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'name',
            'publisher_id',
            'number_of_players',
            'playtime',
        ]);
    }

    public function test_successful_boardgame_creation(): void
    {
        $response = $this
            ->withHeader('Accept', 'application/json')
            ->withHeader('Authorization', 'Bearer ' . $this->getDefaultUserToken())
            ->post(
                self::BOARDGAMES_URL,
                [
                    'name' => fake()->word(),
                    'publisher_id' => Publisher::first()->id,
                    'number_of_players' => 1,
                    'playtime' => 60,
                ]
            );

        $response->assertStatus(201);

        $content = $response->getOriginalContent();

        $this->assertDatabaseHas('boardgames', [
            'id' => $content->id,
            'name' => $content->name,
            'publisher_id' => $content->publisher_id,
            'number_of_players' => $content->number_of_players,
            'playtime' => $content->playtime,
        ]);
    }
}
