<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Team;

class TeamsSeeder extends Seeder
{
    public function run()
    {
        $teams = [
            ['id' => 1, 'nama_tim' => 'Tim Alpha'],
            ['id' => 2, 'nama_tim' => 'Tim Bravo'],
            ['id' => 3, 'nama_tim' => 'Tim Charlie'],
            ['id' => 4, 'nama_tim' => 'Tim Delta'],
            ['id' => 5, 'nama_tim' => 'Tim Echo'],
        ];

        foreach ($teams as $team) {
            Team::create($team);
        }
    }
}
