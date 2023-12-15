<?php

use App\Http\Controllers\Api\AuthController;
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
        Route::post('logout',[AuthController::class, 'logout']);
    });
});