<?php

namespace App\Actions\Auth;

use App\Mail\ResetPassword;
use App\Services\AccessPin;
use Illuminate\Support\Facades\Mail;
use App\Models\{PasswordReset, User};
use App\Http\Requests\Auth\TokenPasswordRequest;

class SendPasswordToken
{
    /**
     * Send the password token for reset.
     *
     * @param TokenPasswordRequest $request
     *
     * @return void
     */
    public function execute(TokenPasswordRequest $request): void
    {
        PasswordReset::whereEmail($request->email)->delete();

        $user = User::firstWhere('email', $request->email);

        $pin = (new AccessPin)->generate($user);
        Mail::to($request->email)->send(new ResetPassword($pin));
    }
}
