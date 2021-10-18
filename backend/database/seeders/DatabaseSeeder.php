<?php

namespace Database\Seeders;

use App\Models\DefaultTeam;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DefaultTeam::insert([
            ['name' => 'Chelsea', 'strength' => 6], 
            ['name' => 'Manchester United', 'strength' => 8], 
            ['name' => 'Arsenal', 'strength' => 7], 
            ['name' => 'Tottenham', 'strength' => 5]
        ]);
    }
}
