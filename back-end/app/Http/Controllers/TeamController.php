<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            Team::create(['name' => $request->input('name')]);
            return response()->json(['message' => 'Time cadastrado com sucesso!'], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao cadastrar time: ' . $e->getMessage()], 422);
        }
    }

    public function index()
    {
        $teams = Team::all();

        return response()->json($teams);
    }
}
