<?php

use App\Http\Controllers;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->middleware('json.response')->group(function () {
    Route::post('register', Controllers\Auth\RegisterController::class);
    Route::post('login', Controllers\Auth\LoginController::class);

    Route::middleware('auth:sanctum')->group(function () {
        Route::delete('logout', Controllers\Auth\LogoutController::class);

        Route::get('profile', Controllers\ProfileController::class);
    });
});
