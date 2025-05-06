<?php

namespace Database\Seeders;

use App\Models\Boardgame;
use App\Models\Publisher;
use Illuminate\Database\Seeder;

class PublisherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Publisher::factory(10)
            ->has(Boardgame::factory()
                ->count(rand(1, 5))
            )
            ->create();
    }
}
