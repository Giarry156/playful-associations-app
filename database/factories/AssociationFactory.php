<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class AssociationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $usersId = User::all()->pluck('id')->toArray();

        return [
            'name' => fake()->company(),
            'city' => fake()->city(),
            'address' => fake()->address(),
            'president_id' => $usersId[array_rand($usersId)],
        ];
    }

    public function configure()
    {;
            return $this->afterCreating(function ($association) {
                $userIds = User::all()->pluck('id')->toArray();
                $notPresidentUsers = array_diff($userIds, [$association->president_id]);
                $randomUsersIds = array_rand($notPresidentUsers, 4);

                $association->users()->attach([
                    $association->president_id,
                    $notPresidentUsers[$randomUsersIds[0]],
                    $notPresidentUsers[$randomUsersIds[1]],
                    $notPresidentUsers[$randomUsersIds[2]],
                    $notPresidentUsers[$randomUsersIds[3]],
                ]);
        });
    }
}
