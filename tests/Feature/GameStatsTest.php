<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Utils\DefaultUserTestTrait;

class GameStatsTest extends TestCase
{
    use DefaultUserTestTrait;

    public function test_games_stats_retrieve_failed_for_no_auth(): void
    {
        $response = $this
            ->withHeader('Accept', 'application/json')
            ->get(route('games.stats'));

        $response->assertStatus(401);

        $response->assertJson([
            'message' => 'Unauthenticated.',
        ]);
    }

    public function test_top_boardgames_games_stats_retrieve(): void
    {
        // Validating top boardgame ever.
        $response = $this
            ->withHeader('Accept', 'application/json')
            ->withHeader('Authorization', 'Bearer ' . $this->getDefaultUserToken())
            ->get(route('games.stats.top.boardgames.ever'));

        $response->assertStatus(200);

        $response->assertJsonStructure([

        ]);
    }
}
