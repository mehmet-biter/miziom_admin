<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProfileUpdateRequest;
use App\Http\Requests\Admin\UpdatePasswordRequest;
use App\Http\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    private $service;
    public function __construct()
    {
        $this->service = new UserService();
    }
    //profile
    public function profile(){
        try {
            $response = $this->service->userProfile(Auth::id());
            return responseJsonData($response['success'],$response['message'],$response['data']);
        } catch(\Exception $e) {
            storeException('profile',$e->getMessage());
            return responseJsonData(false);
        }
    }

    // update profile
    public function updateProfile(ProfileUpdateRequest $request) {
        try {
            $response = $this->service->userProfileUpdate($request,Auth::id());
            return responseJsonData($response['success'],$response['message'],$response['data']);
        } catch(\Exception $e) {
            storeException('profile update ex', $e->getMessage());
            return responseJsonData(false);
        }
    }

    // update password
    public function changePassword(UpdatePasswordRequest $request) {
        try {
            $response = $this->service->userChangePassword($request,Auth::id());
            return responseJsonData($response['success'],$response['message'],$response['data']);
        } catch(\Exception $e) {
            storeException('changePassworde ex', $e->getMessage());
            return responseJsonData(false);
        }
    }
}
