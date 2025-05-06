<?php

namespace Database\Factories;

use App\Models\Publisher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class BoardgameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $publishersIds = Publisher::all()->pluck('id')->toArray();

        return [
            'name' => fake()->word(),
            'number_of_players' => fake()->numberBetween(1, 10),
            'playtime' => fake()->numberBetween(10, 300),
            'publisher_id' => $publishersIds[array_rand($publishersIds)],
        ];
    }
}
