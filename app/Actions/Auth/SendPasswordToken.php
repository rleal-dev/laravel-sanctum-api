<?php

namespace App\Actions\Auth;

use App\Mail\ResetPassword;
use App\Models\{PasswordReset, User};
use Illuminate\Support\Facades\Mail;

class SendPasswordToken
{
    /**
     * Send the password token for reset.
     *
     * @param mixed $request
     *
     * @return void
     */
    public function execute($request): void
    {
        PasswordReset::whereEmail($request->email)->delete();

        $user = User::firstWhere('email', $request->email);

        Mail::to($request->email)->send(
            new ResetPassword($user->generatePin())
        );
    }
}
