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
   public function getSuccesPlayers(){


   }
   public function getRollsPlayer($id){

   }
   public function ranking(){

   }
   public function getLoserPlayer(){

   }
   public function getWinerPlayer(){

   }
    
}
