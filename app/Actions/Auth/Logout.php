<?php

namespace App\Actions\Auth;

class Logout
{
    /**
     * User Logout.
     *
     * @param mixed $request
     *
     * @return boolean
     */
    public function execute($request): bool
    {
        if ($request->logout_mode == 'CURRENT_TOKEN') {
            return $request->user()->currentAccessToken()->delete();
        }

        return $request->user()->tokens()->delete();
    }
}
