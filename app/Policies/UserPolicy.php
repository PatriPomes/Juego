<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;
    
    public function update(User $loggedInUser, User $targetUser)
    {
    return $loggedInUser->id === $targetUser->id;
    }
    public function roleAdmin(User $user){

        return $user->hasRole('Admin');
    }
}
