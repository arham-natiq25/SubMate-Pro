<?php

use App\Http\Controllers\Auth\EmailActivationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\PasswordUpdateController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\RefreshTokenController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResendActivationEmailController;
use App\Http\Controllers\Auth\ResetPasswordLinkController;
use App\Http\Controllers\Backend\BuySubscriptionForAnotherUser;
use App\Http\Controllers\Backend\GetCustomerCardsController;
use App\Http\Controllers\Backend\GetLoggedInUserSubscriptionPlan;
use App\Http\Controllers\Backend\UserSubscriptionVerifyController;
use App\Http\Controllers\Plans\PlanController;
use App\Http\Controllers\Subscription\SubscriptionController;
use App\Models\Plan;
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
Route::post('/update-password/{token}',PasswordUpdateController::class)->name('password.update');
Route::post('/resend/email', ResendActivationEmailController::class)->name('resend-email');


Route::group(['middleware'=>'auth:api'],function () {
   Route::get('/profile',ProfileController::class)->name('profile');
   Route::get('/refresh',RefreshTokenController::class)->name('refresh');
   Route::get('/logout',LogoutController::class)->name('logout');
   Route::get('/check-subcription',UserSubscriptionVerifyController::class)->name('user.subscription');
   Route::get('/user-subsciption',GetLoggedInUserSubscriptionPlan::class)->name('subcribed-plan');
   Route::get('/customer-cards',GetCustomerCardsController::class)->name('customer-cards');
   /** END APIS OF AUTHENTICATION  */

   /**  PLAN CONTROLLER  */
   Route::post('/plans/update/{id}',[PlanController::class,'updatePlan'])->name('plan.store');
   Route::delete('/plans/delete/{id}',[PlanController::class,'deletePlan'])->name('plan.delete');
   Route::post('/plans',[PlanController::class,'storePlan'])->name('plan.store');
   Route::get('/plans/{id}/edit',[PlanController::class,'editPlan'])->name('plan.edit');
});
Route::get('/plans', [PlanController::class,'index']);

/** END PLAN CONTROLLER  */

Route::post('/member/buy-subscription',BuySubscriptionForAnotherUser::class)->name('member.subscription');
   Route::post('/buy-subscription',SubscriptionController::class)->name('subscription');
