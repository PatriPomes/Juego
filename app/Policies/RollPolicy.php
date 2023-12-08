<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Roll;
use Illuminate\Auth\Access\HandlesAuthorization;


class RollPolicy
{
    use HandlesAuthorization;
   
    public function rolePlayer(User $user){

        return $user->hasRole('Player');
    }
    public function roleAdmin(User $user){

        return $user->hasRole('Admin');
    }
    
}
