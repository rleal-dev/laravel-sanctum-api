<?php

namespace App\Actions\Auth;

use App\Mail\VerifyEmail;
use App\Models\{PasswordReset, User};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ResendToken
{
    /**
     * Create user account.
     *
     * @param mixed $request
     *
     * @return void
     */
    public function execute($request): void
    {
        DB::transaction(function () use ($request) {
            PasswordReset::whereEmail($request->email)->delete();

            $user = User::firstWhere('email', $request->email);

            Mail::to($request->email)->send(
                new VerifyEmail($user->generatePin())
            );
        });
    }
}
