<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\WalletController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

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
        Route::post('logout',[AuthController::class, 'logout']);
        Route::group(['prefix' => 'user'], function () {
            Route::get('profile',[UserController::class, 'profile']);
            Route::post('update-profile',[UserController::class, 'updateProfile']);
            Route::post('change-password',[UserController::class, 'changePassword']);
        });
        Route::group(['prefix' => 'wallet'], function () {
            Route::get('coin-list/{type}',[WalletController::class, 'coinList']);
            Route::get('wallet-list/{type}',[WalletController::class, 'walletList']);
        });
    });
    
});