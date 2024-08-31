<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Word;

class ProfilePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct() {}

    /**
     * Determine if the given word can be edited by the user.
     */
    public function edit(User $user, User $profile)
    {
        return $user->id === $profile->id;
    }
}
