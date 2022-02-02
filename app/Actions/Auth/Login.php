<?php

namespace App\Actions\Auth;

class Login
{
    /**
     * User Login and register token.
     *
     * @param mixed $request
     *
     * @return string
     */
    public function execute($request): String
    {
        $credentials = $request->validated();

        if (! auth()->attempt($credentials)) {
            return false;
        }

        return $request->user()->createToken('auth_token')->plainTextToken;
    }
}
