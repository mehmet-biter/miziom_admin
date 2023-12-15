<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\ForgotPasswordRequest;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Http\Requests\Api\Auth\ResetPasswordRequest;
use App\Http\Requests\Api\Auth\VerifyEmailRequest;
use App\Http\Services\AuthService;

class AuthController extends Controller
{
    private $service;
    public function __construct()
    {
        $this->service = new AuthService();
    }
    
    // common setting
    public function commonSetting()
    {
        try{
            $data = allsetting();
            return responseJsonData(true,__('Data get successfully'),$data);
        } catch(\Exception $e) {
            return responseJsonData(false);
        } 
    }

    // register
    public function register(RegisterRequest $request){
        try {
            $response = $this->service->registerProcess($request);
            return responseJsonData($response['success'],$response['message'],$response['data']);
        } catch(\Exception $e) {
            storeException('register', $e->getMessage());
            return responseJsonData(false,__('Something went wrong'));
        }
    }

    // login
    public function login(LoginRequest $request){
        try {
            $response = $this->service->loginProcess($request);
            return responseJsonData($response['success'],$response['message'],$response['data']);
        } catch(\Exception $e) {
            storeException('login', $e->getMessage());
            return responseJsonData(false,__('Something went wrong'));
        }
    }

    // verify email
    public function verifyEmail(VerifyEmailRequest $request){
        try {
            $response = $this->service->verifyEmailProcess($request);
            return responseJsonData($response['success'],$response['message'],$response['data']);
        } catch(\Exception $e) {
            storeException('verifyEmail', $e->getMessage());
            return responseJsonData(false,__('Something went wrong'));
        }
    }

    // forgot Password
    public function forgotPassword(ForgotPasswordRequest $request){
        try {
            $response = $this->service->sendForgotMailProcess($request);
            return responseJsonData($response['success'],$response['message'],$response['data']);
        } catch(\Exception $e) {
            storeException('forgotPassword', $e->getMessage());
            return responseJsonData(false,__('Something went wrong'));
        }
    }
    // reset Password
    public function resetPassword(ResetPasswordRequest $request){
        try {
            $response = $this->service->passwordResetProcess($request);
            return responseJsonData($response['success'],$response['message'],$response['data']);
        } catch(\Exception $e) {
            storeException('resetPassword', $e->getMessage());
            return responseJsonData(false,__('Something went wrong'));
        }
    }
}
