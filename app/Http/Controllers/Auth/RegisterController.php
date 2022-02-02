<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\Register;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Auth\RegisterRequest;
use Throwable;

class RegisterController extends BaseController
{
    /**
     * Perform user register
     *
     * @param RegisterRequest  $request
     * @param Register  $action
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(RegisterRequest $request, Register $action)
    {
        try {
            $token = $action->execute($request);
        } catch (Throwable $exception) {
            throw_if(is_development(), $exception);

            return $this->responseError('Error on user register!');
        }

        return $this->responseOk('User created successfully!', ['access_token' => $token]);
    }
}
