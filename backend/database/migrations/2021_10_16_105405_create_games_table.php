<?php

use App\Models\Simulation;
use App\Models\Team;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->integer('week');
            $table->foreignIdFor(Team::class, 'home_id')->constrained('teams');
            $table->foreignIdFor(Team::class, 'away_id')->constrained('teams');
            $table->integer('home_score')->nullable();
            $table->integer('away_score')->nullable();
            $table->foreignIdFor(Simulation::class)->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['home_id', 'away_id', 'simulation_id']);
            $table->unique(['week', 'home_id', 'simulation_id']);
            $table->unique(['week', 'away_id', 'simulation_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games');
    }
}
