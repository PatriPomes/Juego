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
    
    $this->authorize('rollDice', Roll::class );

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
    
    $this->authorize('destroyAllRollDice', [Auth::user(), $id] );

    $user = User::find($id);
    $user->rolls()->delete();

    return response()->json(['message'=>'Tus tiradas han sido eliminadas.']);
  }
 
  public function successPlayers(){
   
      $this->authorize('success', Roll::class);

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
      return response()->json(['success_rates' => $successRates]);
  }
  
  public function rollsPlayer($id){ //show
    
    $player = User::find($id); 
  
    $this->authorize('rollsPlayer', Roll::class );

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
           $winningRolls = $player->rolls()->where('winner', true)->count();
   
           $successRate = $totalRolls === 0 ? 0 : ($winningRolls / $totalRolls) * 100;
   
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

    $rankings = collect(json_decode($this->ranking()->getContent(), true)); 
    $losserPlayer = $rankings->last(); 

   return response()->json(['losserPlayer' => $losserPlayer]);
   }
   public function winnerPlayer(){

    $this->authorize('roleAdmin', Roll::class );

    $rankings = collect(json_decode($this->ranking()->getContent(), true)); 
    $winnerPlayer = $rankings->first(); 

   return response()->json(['winnerPlayer' => $winnerPlayer]);
   }
    
}
