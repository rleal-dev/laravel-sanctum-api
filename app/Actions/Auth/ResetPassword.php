<?php

namespace App\Actions\Auth;

use App\Models\{PasswordReset, User};
use Illuminate\Support\Facades\DB;

class ResetPassword
{
    /**
     * Reset the user password.
     *
     * @param mixed $request
     *
     * @return boolean
     */
    public function execute($request): bool
    {
        return DB::transaction(function () use ($request) {
            $token = PasswordReset::query()
                ->where('email', $request->email)
                ->where('token', $request->token)
                ->first();

            if (! $token) {
                return false;
            }

            $tokenTime = now()->diffInSeconds($token->created_at);
            if ($tokenTime > 3600) {
                return false;
            }

            PasswordReset::whereEmail($request->email)->delete();

            $user = User::firstWhere('email', $request->email);

            return $user->update([
                'password' => $request->password,
            ]);
        });
    }
}
