<?php

use App\Http\Controllers\DefaultTeamController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\SimulationController;
use App\Http\Controllers\SimulationPredictionController;
use App\Http\Controllers\SimulationSeasonController;
use App\Http\Controllers\SimulationStatisticsController;
use App\Http\Controllers\SimulationWeekController;
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

Route::get('/teams/default', [DefaultTeamController::class, 'index']);
Route::patch('/games/{game}', [GameController::class, 'update']);

Route::prefix('/simulations')->group(function() {
    Route::get('/{simulation}/prediction', [SimulationPredictionController::class, 'show']);
    Route::get('/{simulation}/statistics', [SimulationStatisticsController::class, 'show']);
    Route::patch('/{simulation}/season', [SimulationSeasonController::class, 'update']);
    Route::patch('/{simulation}/week', [SimulationWeekController::class, 'update']);
    Route::delete('/{simulation}', [SimulationController::class, 'destroy']);
    Route::post('/', [SimulationController::class, 'store']);
    Route::get('/', [SimulationController::class, 'show']);
});
