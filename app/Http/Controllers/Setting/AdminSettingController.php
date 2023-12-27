<?php

namespace App\Http\Controllers\Setting;

use Illuminate\Http\Request;
use App\Http\Services\MailService;
use App\Http\Controllers\Controller;
use App\Http\Services\SettingService;
use Illuminate\Support\Facades\Validator;

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

    public function adminSaveEmailSettings(Request $request)
    {
        if ($request->post()) {
            $rules = [
                'mail_driver' => 'required',
                'mail_host' => 'required'
                ,'mail_port' => 'required'
                ,'mail_username' => 'required'
                ,'mail_password' => 'required'
                ,'mail_encryption' => 'required'
                ,'mail_from_address' => 'required'
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $errors = [];
                $e = $validator->errors()->all();
                foreach ($e as $error) {
                    $errors[] = $error;
                }
                $data['message'] = $errors;
                return redirect()->route('adminSettings', ['tab' => 'email'])->with(['dismiss' => $errors[0]]);
            }

            try {
                $response = $this->service->saveEmailSetting($request);
                if ($response['success'] == true) {
                    return redirect()->route('adminSetting', ['tab' => 'email'])->with('success', $response['message']);
                } else {
                    return redirect()->route('adminSetting', ['tab' => 'email'])->withInput()->with('success', $response['message']);
                }
            } catch(\Exception $e) {
                return redirect()->back()->with(['dismiss' => $e->getMessage()]);
            }
        }
    }

    public function testMail(Request $request)
    {
        $template = 'email.test_mail';
        $mailService = new MailService();
        $companyName = isset(allsetting()['app_title']) && !empty(allsetting()['app_title']) ? allsetting()['app_title'] : __('Company Name');
        $subject = __(' Test Mail | :companyName', ['companyName' => $companyName]);
        $test = $mailService->sendTest($template, [], $request->email, "Name", $subject);

        return redirect()->route('adminSetting', ['tab' => 'email'])->with("success", $test['message']);
    }
}
