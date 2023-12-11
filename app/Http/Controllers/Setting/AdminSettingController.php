<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Http\Services\SettingService;
use Illuminate\Http\Request;

class AdminSettingController extends Controller
{
    private $service;
    public function __construct()
    {
        $this->service = new SettingService();
    }
    
    // admin setting
    public function adminSetting() {
        $data['title'] = __('Admin Setting');
        $data['settings'] = allsetting();
        return view('settings.admin.setting', $data);
    }

    // save common setting
    public function updateGeneralSetting(Request $request) {
        $response = $this->service->saveAdminSetting($request);
        if($response['success']) {
            return redirect()->back()->with('success',$response['message']);
        } else {
            return redirect()->back()->with('dismiss',$response['message']);
        }
    }
}
