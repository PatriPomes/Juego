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


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/payers', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login'])->name('login');

Route::post('/logout',[UserController::class, 'logout'])->name('logout')->middleware('auth:api');

Route::put('/players/{id}',[UserController::class, 'update'])->name('update')->middleware('auth:api');

Route::post('/players/{id}/games',[RollController::class, 'rollDice'])->name('rollDice')->middleware('auth:api');

Route::delete('/players/{id}/games',[RollController::class, 'destroyAllRollDice'])->name('destroyAllRollDice')->middleware('auth:api');

Route::get('/players',[RollController::class, 'getSuccesPlayers'])->name('getSuccesPlayers')->middleware('auth:api');

Route::get('/players/{id}/games',[RollController::class, 'getRollsPlayer'])->name('getRollsPlayer')->middleware('auth:api');
// Route::middleware('auth:api')->group(function () {
    //aqui incluiremos las rutas que queramos proteger con token de acceso
// });