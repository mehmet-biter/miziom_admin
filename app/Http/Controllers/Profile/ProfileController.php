<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProfileUpdateRequest;
use App\Http\Requests\Admin\UpdatePasswordRequest;
use App\Http\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    private $service;

    public function __construct()
    {
        $this->service = new UserService();
    }

    //my profile
    public function index(){
        $data['title'] = __('My Profile');
        $data['user'] = Auth::user();
        return view('profile.index', $data);
    }

    //update my profile
    public function edit(){
        $data['title'] = __('Update Profile');
        $data['user'] = Auth::user();
        return view('profile.update', $data);
    }

    // update profile
    public function update(ProfileUpdateRequest $request) {
        try {
            $response = $this->service->userProfileUpdate($request,Auth::id());
            if($response['success']) {
                return redirect()->back()->with('success',$response['message']);
            } else {
                return redirect()->back()->withInput()->with('dismiss',$response['message']);
            }
        } catch(\Exception $e) {
            storeException('profile update ex', $e->getMessage());
            return redirect()->back()->with('dismiss', __('Something went wrong'));
        }
    }


    // update password
    public function changePassword(UpdatePasswordRequest $request) {
        try {
            $response = $this->service->userChangePassword($request,Auth::id());
            if($response['success']) {
                return redirect()->back()->with('success',$response['message']);
            } else {
                return redirect()->back()->withInput()->with('dismiss',$response['message']);
            }
        } catch(\Exception $e) {
            storeException('changePassworde ex', $e->getMessage());
            return redirect()->back()->with('dismiss', __('Something went wrong'));
        }
    }
}
