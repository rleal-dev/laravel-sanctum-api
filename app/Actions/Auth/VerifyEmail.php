<?php

namespace App\Actions\Auth;

use App\Models\{PasswordReset, User};
use Illuminate\Support\Facades\DB;

class VerifyEmail
{
    /**
     * Create user account.
     *
     * @param mixed $request
     *
     * @return string
     */
    public function execute($request): string
    {
        return DB::transaction(function () use ($request) {
            $token = PasswordReset::firstWhere('token', $request->token);

            if (! $token) {
                return false;
            }

            $user = User::firstWhere('email', $token->email);
            $user->email_verified_at = now()->getTimestamp();
            $user->save();

            return PasswordReset::whereToken($request->token)->delete();
        });
    }
}
