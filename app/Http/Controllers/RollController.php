<?php

namespace App\Http\Controllers;

use App\Models\Roll;
use App\Http\Requests\StoreRollsRequest;
use App\Http\Requests\UpdateRollsRequest;
use App\Models\User;

class RollController extends Controller
{
    /**
     * Display a listing of the resource.
     */
  public function rollDice($id){
        
    $dice1 = rand(1, 6);
    $dice2 = rand(1, 6);
    
    $total = $dice1 + $dice2;
    
    $winner = $total > 7 ? true : false;
    
    $roll = Roll::create([
      'dice1' => $dice1,
      'dice2' => $dice2,
      'total' => $total,
      'winner' => $winner,
      'user_id' => $id
    ]);

    $roll->save();
    
      return response()->json($roll, 201);
  }
  public function destroyAllRollDice($id){

    User::destroy($id);

    return response()->json(['message'=>'Tus tiradas han sido eliminadas.']);
  }
   //index()

  public function successRate(){
    $players = User::all();
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
    $totalRolls = $player->rolls()->count();
    $winningRolls = $player->rolls()->where('winner', true)->count();

    $successRate = $totalRolls === 0 ? 0 : ($winningRolls / $totalRolls) * 100;

    $player->success_rate = $successRate;

    return response()->json($player);

   }
  public function ranking(){
      $players = User::all();
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
   
       /*usort($rankings, function ($a, $b) {
           if ($a['success_rate'] == $b['success_rate']) {
               return $a['total_rolls'] <=> $b['total_rolls'];
           }
           return $b['success_rate'] <=> $a['success_rate'];
       });*/
    return response()->json(['rankings' => $rankings]);
  }
 
   public function losser(){
    return $this->ranking()->last();
   }
   public function winner(){
    return $this->ranking()->first();
   }
    
}
