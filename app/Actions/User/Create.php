<?php

namespace App\Actions\User;

use App\Models\User;

class Create
{
    /**
     * Create a user
     *
     * @param mixed $request
     *
     * @return User
     */
    public function execute($request)
    {
        return User::create($request->validated());
    }
}
