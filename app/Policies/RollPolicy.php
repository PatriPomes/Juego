<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Roll;
use Illuminate\Auth\Access\HandlesAuthorization;


class RollPolicy
{
    use HandlesAuthorization;
    public function author(User $user, $id)
    {
        if($user->id== $id){
            return true;

        }else{
            return false;
        }
    }
    public function rollDice(User $user,$id){

    return $user->hasRole('Player')&& $user->id == $id;
    }
    public function destroyAllRollDice(User $user,$id){

        return $user->hasRole('Player')&& $user->id == $id;
    }
    public function success(User $user){

        return $user->hasRole('Admin');
    }
    public function rollsPlayer(User $user){
       
        return  $user->hasRole('Player') ;
    }
    public function roleAdmin(User $user){

        return $user->hasRole('Admin');
    }
    
}
