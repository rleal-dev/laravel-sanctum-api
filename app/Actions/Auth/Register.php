<?php

namespace App\Actions\Auth;

use App\Mail\VerifyEmail;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class Register
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
            $user = User::create($request->validated());

            Mail::to($request->email)->send(
                new VerifyEmail($user->generatePin())
            );

            return $user->createToken('auth_token')->plainTextToken;
        });
    }
}
