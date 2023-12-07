<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
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
    public function update(User $loggedInUser, User $targetUser)
    {
    return $loggedInUser->id === $targetUser->id;
    }
}
