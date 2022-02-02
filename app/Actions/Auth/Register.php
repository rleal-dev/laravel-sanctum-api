<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class Register
{
    /**
     * Create user and return the access token.
     *
     * @param mixed $request
     *
     * @return string
     */
    public function execute($request): String
    {
        return DB::transaction(function () use ($request) {
            $user = User::create($request->validated());

            return $user->createToken('auth_token')->plainTextToken;
        });
    }
}
