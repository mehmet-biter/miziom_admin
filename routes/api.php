<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\IconController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\WalletNotifier;
use App\Http\Controllers\Api\WalletController;
use App\Http\Controllers\Setting\FaqController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('bitgo-wallet-webhook',[WalletNotifier::class, 'bitgoWalletWebhook']);
Route::group(['namespace'=>'Api','middleware' => ['apiCheck']], function (){
    Route::group(['prefix'=>'auth'], function (){
        Route::get('common-setting',[AuthController::class, 'commonSetting']);
        Route::post('sign-up',[AuthController::class, 'register']);
        Route::post('login',[AuthController::class, 'login']);
        Route::post('verify-email',[AuthController::class, 'verifyEmail']);
        Route::post('forgot-password',[AuthController::class, 'forgotPassword']);
        Route::post('reset-password',[AuthController::class, 'resetPassword']);
    });

    Route::group(['middleware' => ['auth:api']], function () {
        //logout
        Route::get('logout',[AuthController::class, 'logout']);
        Route::group(['prefix' => 'user'], function () {
            Route::get('profile',[UserController::class, 'profile']);
            Route::post('update-profile',[UserController::class, 'updateProfile']);
            Route::post('change-password',[UserController::class, 'changePassword']);
        });
        Route::group(['prefix' => 'wallet'], function () {
            Route::get('coin-list/{type}',[WalletController::class, 'coinList']);
            Route::get('wallet-list/{type}',[WalletController::class, 'walletList']);
            Route::get('customer',[WalletController::class, 'searcheCustomer']);
            Route::get('withdrawal',[WalletController::class, 'walletWithdrawal']);
            Route::get('deposit',[WalletController::class, 'walletDeposit']);
            Route::get('transaction',[WalletController::class, 'getTransaction']);
            Route::post('withdrawal-proccess',[WalletController::class, 'walletWithdrawalProccess']);
        });
        Route::post('exchange-rate',[WalletController::class, 'exchangeRate']);
        Route::get('faq', [FaqController::class, 'getFaqApi']);
        Route::get('get-icon-list', [IconController::class, 'getIcons']);
    });
    Route::get('page/{slug}', [AuthController::class, 'getDataBySlug']);    
});