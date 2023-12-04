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
}
