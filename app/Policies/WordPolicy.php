<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Word;

class WordPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct() {}

    /**
     * Determine if the given word can be edited by the user.
     */
    public function edit(User $user, Word $word)
    {
        return $user->id === $word->user_id;
    }

    /**
     * Determine if the given word can be deleted by the user.
     */
    public function delete(User $user, Word $word)
    {
        return $user->id === $word->user_id;
    }
}
