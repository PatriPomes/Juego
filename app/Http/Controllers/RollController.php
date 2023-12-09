<?php

namespace App\Http\Controllers;

use App\Models\Roll;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class RollController extends Controller
{

  public function rollDice($id){
    
    $player = User::find($id);
    $this->authorize('rolePlayer', Roll::class );
    if ($player->id!== Auth::user()->id){
      return response()->json(['message' => 'Forbbiden'], 403);
    }

    $dice1 = rand(1, 6);
    $dice2 = rand(1, 6);
    $total = $dice1 + $dice2;
    $winner = $total === 7 ? true : false;
    
    $roll = Roll::create([
      'dice1' => $dice1,
      'dice2' => $dice2,
      'total' => $total,
      'winner' => $winner,
      'user_id' => $id
    ]);

    $roll->save();
    
    return response()->json($roll);
  }
  public function destroyAllRollDice($id){
    
    $player = User::find($id);
    $this->authorize('rolePlayer', Roll::class );
    if ($player->id!== Auth::user()->id){
      return response()->json(['message' => 'Forbbiden'], 403);
    }

    
    $player->rolls()->delete();

    return response()->json(['message'=>'Tus tiradas han sido eliminadas.']);
  }
 
  public function successPlayers(){
   
    $this->authorize('roleAdmin', Roll::class);

    $players = User::role('Player')->get();
    $successRates = [];
    foreach ($players as $player) {
        $totalRolls = $player->rolls()->count();
        $winningRolls = $player->rolls()->where('winner', true)->count();
        if ($totalRolls === 0) {
            $successRates[$player->name] = 0;
        } else {
            $successRates[$player->name] = ($winningRolls / $totalRolls) * 100;
        }
    }
    return $successRates;
  }
  
  public function rollsPlayer($id){ 
    
    $player = User::find($id); 
    $this->authorize('rolePlayer', Roll::class );
    if ($player->id!== Auth::user()->id){
      return response()->json(['message' => 'Forbbiden'], 403);
    }
    
    $totalRolls = $player->rolls()->count();
    $winningRolls = $player->rolls()->where('winner', true)->count();

    $successRate = $totalRolls === 0 ? 0 : ($winningRolls / $totalRolls) * 100;

    $player->success_rate = $successRate;

    $rolls = $player->rolls()->get();

    $player->rolls = $rolls;
    
    return response()->json($player);

  }
  public function ranking(){
    
    Auth::guard('api')->check();

    $players = User::role('Player')->get();
    $rankings = [];
   
    foreach ($players as $player) {
        $totalRolls = $player->rolls()->count();
        if ($totalRolls === 0) {
            continue; // Si el jugador no tiene ninguna tirada, pasa al siguiente jugador
        }
        $winningRolls = $player->rolls()->where('winner', true)->count();
        $successRate = ($winningRolls / $totalRolls) * 100;
   
        $rankings[] = [
            'name' => $player->name,
            'success_rate' => $successRate,
            'total_rolls' => $totalRolls,
        ];
    }
    $rankings = collect($rankings)->sortBy('total_rolls')->sortByDesc('success_rate')->values()->all();
    return response()->json(['rankings' => $rankings]);
}
 
  public function losserPlayer(){

    $this->authorize('roleAdmin', Roll::class );

    $successRates = $this->successPlayers();
    $losserPlayerName = array_search(min($successRates), $successRates);
    $losserPlayer = User::where('name', $losserPlayerName)->first();

    return response()->json(['losserPlayer' => $losserPlayer, 'success_rate' => $successRates[$losserPlayerName]]);
  }
  public function winnerPlayer(){

    $this->authorize('roleAdmin', Roll::class );

    $successRates = $this->successPlayers();
    $winnerPlayerName = array_search(max($successRates), $successRates);
    $winnerPlayer = User::where('name', $winnerPlayerName)->first();

    return response()->json(['winnerPlayer' => $winnerPlayer, 'success_rate' => $successRates[$winnerPlayerName]]);
  }
    
}
