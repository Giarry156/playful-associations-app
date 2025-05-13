<?php

namespace Database\Factories;

use App\Models\Association;
use App\Models\Boardgame;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Game>
 */
class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $boardgamesIds = Boardgame::all()->pluck('id')->toArray();
        $associationsIds = Association::all()->pluck('id')->toArray();

        return [
            'association_id' => $associationsIds[array_rand($associationsIds)],
            'boardgame_id' => $boardgamesIds[array_rand($boardgamesIds)],
            'created_at' => fake()->dateTimeBetween('-1 year'),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function ($game) {
            $userIds = User::whereHas(
                'associations',
                fn($q) => $q->where('association_id', $game->association_id)
            )
                ->pluck('id')
                ->toArray();

            if (count($userIds) < 2) return;

            shuffle($userIds);
            $randomUsersIds = array_slice($userIds, 0, count($userIds) - 1);
            $game->users()->attach($randomUsersIds);
        });
    }
}
