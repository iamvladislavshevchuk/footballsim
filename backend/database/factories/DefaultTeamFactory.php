<?php

namespace Database\Factories;

use App\Models\DefaultTeam;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

class DefaultTeamFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DefaultTeam::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->name,
            'strength' => $this->faker->numberBetween(1, 10)
        ];
    }
}
