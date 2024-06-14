<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Championship;
use App\Models\Matches;
use App\Models\Team;
use Illuminate\Support\Facades\DB;

class MatchesTableSeeder extends Seeder
{
    public function run()
    {
        $championship = Championship::first();

        // Create quarterfinals
        $teams = ['Team A', 'Team B', 'Team C', 'Team D', 'Team E', 'Team F', 'Team G', 'Team H'];
        shuffle($teams);
        for ($i = 0; $i < 4; $i++) {
            $team1 = array_shift($teams);
            $team2 = array_shift($teams);
            Matches::create([
                'championship_id' => $championship->id,
                'round' => 'quarterfinals',
                'team1' => $team1,
                'team2' => $team2,
                'score1' => rand(0, 5),
                'score2' => rand(0, 5),
            ]);
        }

        // Create semifinals
        $quarterfinals = Matches::where('championship_id', 1)
            ->where('round', 'quarterfinals')
            ->get();
        $semifinalTeams = [];
        foreach ($quarterfinals as $match) {
            if ($match->score1 > $match->score2) {
                $semifinalTeams[] = $match->team1;
            } else {
                $semifinalTeams[] = $match->team2;
            }
        }
        shuffle($semifinalTeams);
        for ($i = 0; $i < 2; $i++) {
            $team1 = array_shift($semifinalTeams);
            $team2 = array_shift($semifinalTeams);
            Matches::create([
                'championship_id' => 1,
                'round' => 'semifinals',
                'team1' => $team1,
                'team2' => $team2,
                'score1' => rand(0, 5),
                'score2' => rand(0, 5),
            ]);
        }

        // Create final
        $semifinals = Matches::where('championship_id', 1)
            ->where('round', 'semifinals')
            ->get();
        $finalTeams = [];
        foreach ($semifinals as $match) {
            if ($match->score1 > $match->score2) {
                $finalTeams[] = $match->team1;
            } else {
                $finalTeams[] = $match->team2;
            }
        }
        $team1 = array_shift($finalTeams);
        $team2 = array_shift($finalTeams);
        Matches::create([
            'championship_id' => 1,
            'round' => 'final',
            'team1' => $team1,
            'team2' => $team2,
            'score1' => rand(0, 5),
            'score2' => rand(0, 5),
        ]);
    }
}
