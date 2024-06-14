<?php

namespace App\Http\Controllers;

use App\Models\Championship;
use App\Models\Matches;
use App\Models\Team;
use Illuminate\Http\Request;

class ChampionshipController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'teams' => 'required|array|size:8',
            'teams.*' => 'required|string|max:255'
        ]);

        $championship = Championship::create(['name' => $request->name]);

        foreach ($request->teams as $teamName) {
            $championship->teams()->create(['name' => $teamName]);
        }

        return response()->json($championship->load('teams'), 201);
    }

    public function index()
    {
        $championships = Championship::with('teams')->get();
        return response()->json([
            'success' => true,
            'data' => $championships
        ]);
    }

    public function getChampionshipsWithMatches()
    {
        $championships = Championship::with('matches')->get();
        return response()->json(['success' => true, 'data' => $championships]);
    }

    public function getTeamsByChampionship($id)
    {
        $championship = Championship::findOrFail($id);

        $teams = $championship->teams()->with('championship:id,name')->get();

        return response()->json([
            'success' => true,
            'data' => $teams
        ]);
    }

    public function processar(Request $request)
    {
        // Validar os dados recebidos
        $request->validate([
            'name' => 'required|string',
            'teams' => 'required|array|size:8',
            'teams.*' => 'required|string',
        ]);
        $championship = Championship::create([
            'name' => $request->input('name'),
        ]);
        $teams = $request->input('teams');
        $matches = [];

        // Quartas de final
        shuffle($teams);
        for ($i = 0; $i < 4; $i++) {
            $pair = array_slice($teams, $i * 2, 2);
            $team1 = $pair[0];
            $team2 = $pair[1];
            $score1 = rand(0, 5);
            $score2 = rand(0, 5);
            Matches::create([
                'championship_id' => $championship->id,
                'round' => 'quartas de final',
                'team1' => $team1,
                'team2' => $team2,
                'score1' => $score1,
                'score2' => $score2,
            ]);
        }

        // Semifinal
        $teams = array_slice($teams, 0, 4);
        for ($i = 0; $i < 2; $i++) {
            $team1 = $teams[$i * 2];
            $team2 = $teams[$i * 2 + 1];
            $score1 = rand(0, 5);
            $score2 = rand(0, 5);
            Matches::create([
                'championship_id' => $championship->id,
                'round' => 'semifinal',
                'team1' => $team1,
                'team2' => $team2,
                'score1' => $score1,
                'score2' => $score2,
            ]);
        }

        // Final
        $teams = array_slice($teams, 0, 2);
        $team1 = $teams[0];
        $team2 = $teams[1];
        $score1 = rand(0, 5);
        $score2 = rand(0, 5);
        Matches::create([
            'championship_id' => $championship->id,
            'round' => 'final',
            'team1' => $team1,
            'team2' => $team2,
            'score1' => $score1,
            'score2' => $score2,
        ]);

        return response()->json(['success' => true]);
    }
    // $data = $request->all();
    // if (!isset($data['name']) || !isset($data['teams']) || count($data['teams']) < 8) {
    //     return response()->json(['error' => 'Dados inválidos'], 400);
    // }
    // $championship = Championship::create(['name' => $data['name']]);
    // $quarterfinals = gerarJogos($data['teams'], 4);
    // $semifinals = gerarJogos($quarterfinals['vencedores'], 2);
    // $final = gerarJogo($semifinals['vencedores'][0], $semifinals['vencedores'][1]);
    // foreach ($quarterfinals['jogos'] as $quarterfinal) {
    //     Matches::create([
    //         'championship_id' => $championship->id,
    //         'round' => 'quarterfinals',
    //         'team1' => $quarterfinal['time1'],
    //         'team2' => $quarterfinal['time2'],
    //         'score1' => rand(0, 9),
    //         'score2' => rand(0, 9),
    //     ]);
    // }

    // foreach ($semifinals['jogos'] as $semifinal) {
    //     Matches::create([
    //         'championship_id' => $championship->id,
    //         'round' => 'semifinals',
    //         'team1' => $semifinal['time1'],
    //         'team2' => $semifinal['time2'],
    //         'score1' =>  rand(0, 9),
    //         'score2' =>  rand(0, 9),
    //     ]);
    // }

    // function gerarJogos($teams, $numJogos)
    // {
    //     $jogos = [];
    //     $vencedores = [];
    //     $perdedores = [];

    //     for ($i = 0; $i < $numJogos; $i++) {
    //         $time1 = array_shift($teams);
    //         $time2 = array_shift($teams);

    //         $jogo = [
    //             'time1' => $time1,
    //             'time2' => $time2,
    //             'placar1' => rand(0, 9),
    //             'placar2' => rand(0, 9),
    //         ];

    //         if ($jogo['placar1'] > $jogo['placar2']) {
    //             $vencedores[] = $time1;
    //             $perdedores[] = $time2;
    //         } else {
    //             $vencedores[] = $time2;
    //             $perdedores[] = $time1;
    //         }

    //         $jogos[] = $jogo;
    //     }

    //     return [
    //         'jogos' => $jogos,
    //         'vencedores' => $vencedores,
    //         'perdedores' => $perdedores,
    //     ];
    // }

    // function gerarJogo($time1, $time2)
    // {
    //     return [
    //         'time1' => $time1,
    //         'time2' => $time2,
    //         'placar1' => rand(0, 5),
    //         'placar2' => rand(0, 5),
    //     ];
    // }
    // return response()->json([
    //     'championship' => $championship,
    //     'data' => [$quarterfinals, $semifinals, $final]
    // ]);

}
