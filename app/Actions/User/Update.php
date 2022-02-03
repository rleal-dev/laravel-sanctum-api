<?php

namespace App\Actions\User;

use App\Models\User;

class Update
{
    /**
     * Update a user
     *
     * @param User $user
     * @param mixed $request
     *
     * @return boolean
     */
    public function execute(User $user, $request)
    {
        return $user->update($request->validated());
    }
}
