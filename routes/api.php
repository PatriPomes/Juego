<?php

use App\Http\Controllers\RollController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Passport;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::post('/players', [UserController::class, 'playerRegister']);

// Route::post('/adminRegister', [UserController::class, 'adminRegister'])->middleware('auth:api');

// Route::post('/login', [UserController::class, 'login'])->name('login');
// Route::post('/logout',[UserController::class, 'logout'])->name('logout')->middleware('auth:api');
// Route::put('/players/{id}',[UserController::class, 'update'])->name('update')->middleware('auth:api');

// Route::post('/players/{id}/games',[RollController::class, 'rollDice'])->name('rollDice')->middleware('auth:api');
// Route::delete('/players/{id}/games',[RollController::class, 'destroyAllRollDice'])->name('destroyAllRollDice')->middleware('auth:api');
// Route::get('/players',[RollController::class, 'succesPlayers'])->name('succesPlayers')->middleware('auth:api');
// Route::get('/players/{id}/games',[RollController::class, 'rollsPlayer'])->name('rollsPlayer')->middleware('auth:api');
// Route::get('/players/ranking',[RollController::class, 'ranking'])->name('ranking')->middleware('auth:api');
// Route::get('/players/ranking/losser',[RollController::class, 'loser'])->name('losser')->middleware('auth:api');
// Route::get('/players/ranking/winner',[RollController::class, 'winner'])->name('winner')->middleware('auth:api');



Route::post('/players', [UserController::class, 'playerRegister']);
Route::post('/login', [UserController::class, 'login'])->name('login');

Route::middleware('auth:api')->group(function () {
    
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
    Route::put('/players/{id}',[UserController::class, 'update'])->name('update');
    Route::get('/players/ranking',[RollController::class, 'ranking'])->name('ranking');

    Route::middleware('role:Admin')->group(function () {
        Route::post('/adminRegister', [UserController::class, 'adminRegister'])->name('adminRegister');
        Route::get('/players',[RollController::class, 'successPlayers'])->name('successPlayers');
        Route::get('/players/ranking/losser',[RollController::class, 'loser'])->name('losser');
        Route::get('/players/ranking/winner',[RollController::class, 'winner'])->name('winner');

    });

    Route::middleware('role:Player')->group(function () {
        Route::post('/players/{id}/games',[RollController::class, 'rollDice'])->name('rollDice');
        Route::delete('/players/{id}/games',[RollController::class, 'destroyAllRollDice'])->name('destroyAllRollDice');
        Route::get('/players/{id}/games',[RollController::class, 'rollsPlayer'])->name('rollsPlayer');
        
    });
});