<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ChampionshipController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// desativado middleware por nao estar gerando passport
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('login', [LoginController::class, 'login']);
Route::post('teams', [TeamController::class, 'store']);
Route::get('teams', [TeamController::class, 'index']);
Route::get('/championships/{id}/teams', [ChampionshipController::class, 'getTeamsByChampionship']);
Route::get('/championships', [ChampionshipController::class, 'index']);
Route::get('/championships/matches', [ChampionshipController::class, 'getChampionshipsWithMatches']);
Route::post('/championships', [ChampionshipController::class, 'create']);
Route::post('/championships/processar', [ChampionshipController::class, 'processar']);
