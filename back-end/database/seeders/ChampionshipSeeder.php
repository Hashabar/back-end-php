<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Championship;
use App\Models\Team;

class ChampionshipSeeder extends Seeder
{
    public function run()
    {
        Championship::create([
            'name' => 'Campeonato Exemplo'
        ]);
        $teams = [
            'Time 1',
            'Time 2',
            'Time 3',
            'Time 4',
            'Time 5',
            'Time 6',
            'Time 7',
            'Time 8'
        ];
        foreach ($teams as $teamName) {
            Team::create([
                'name' => $teamName,
                'championship_id' => 1
            ]);
        }
    }
}
