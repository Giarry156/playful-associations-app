<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('boardgames', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('number_of_players')->nullable();
            $table->integer('playtime')->nullable();
            $table->foreignId('publisher_id')->constrained('publishers');
            $table->timestamps();
        });

        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->foreignId('association_id')->constrained('associations');
            $table->foreignId('boardgame_id')->constrained('boardgames');
            $table->timestamps();
        });

        Schema::create('game_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained('games');
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_user');
        Schema::dropIfExists('games');
        Schema::dropIfExists('boardgames');
    }
};
