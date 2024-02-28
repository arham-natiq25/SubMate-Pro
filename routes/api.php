<?php

use App\Http\Controllers\Auth\EmailActivationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\RefreshTokenController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordLinkController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



/** APIS OF AUTHENTICATION */
Route::post('/register',RegisterController::class)->name('register');
Route::post('/login',LoginController::class)->name('login');
Route::get('/email/active/{token}', EmailActivationController::class)->name('email.active');
Route::post('/reset-password', ResetPasswordLinkController::class)->name('reset-user-password');



Route::group(['middleware'=>'auth:api'],function () {
   Route::get('/profile',ProfileController::class)->name('profile');
   Route::get('/refresh',RefreshTokenController::class)->name('refresh');
   Route::get('/logout',LogoutController::class)->name('logout');
});

/** END APIS OF AUTHENTICATION  */
