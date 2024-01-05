<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Repository\SettingRepository;

class SettingController extends Controller
{
    private $settingRepo;
    private $faqTypeService;
    private $faqService;
    private $adminSettingService;
    public function __construct()
    {
        $this->settingRepo = new SettingRepository();
        // $this->adminSettingService = new AdminSettingService();
    }
    public function bitgoSetting()
    {
        $data['title'] = __('Bitgo Settings');
        $data['settings'] = allsetting();
        return view('setting.bitgo', $data);
    }

    public function coinPaymentSetting()
    {
        $data['title'] = __('Coin Payment Settings');
        $data['settings'] = allsetting();
        return view('setting.coin-payment', $data);
    }

    public function adminSaveBitgoSettings(Request $request)
    {
        if ($request->post()) {
            $rules = [
                'bitgo_api' => 'required|max:255',
                'bitgoExpess' => 'required|max:255',
                'BITGO_ENV' => 'required|max:255|in:test,live',
                'bitgo_token' => 'required|max:255'
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $errors = [];
                $e = $validator->errors()->all();
                foreach ($e as $error) {
                    $errors[] = $error;
                }
                $data['message'] = $errors;
                return redirect()->back()->with(['dismiss' => $errors[0]]);
            }

            try {
                $response = $this->settingRepo->saveBitgoSetting($request);
                if ($response['success'] == true) {
                    return redirect()->back()->with('success', $response['message']);
                } else {
                    return redirect()->back()->withInput()->with('success', $response['message']);
                }
            } catch(\Exception $e) {
                return redirect()->back()->with(['dismiss' => $e->getMessage()]);
            }
        }
    }
    
    public function apiServicSave(Request $request)
    {
        if ($request->post()) {
            $rules = [
                'CURRENCY_EXCHANGE_RATE_API_KEY' => 'required|max:255',
                'CRYPTO_COMPARE_API_KEY' => 'required|max:255',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $errors = [];
                $e = $validator->errors()->all();
                foreach ($e as $error) {
                    $errors[] = $error;
                }
                $data['message'] = $errors;
                return redirect()->back()->with(['dismiss' => $errors[0]]);
            }

            try {
                $response = $this->settingRepo->saveApiServiceSetting($request);
                if ($response['success'] == true) {
                    return redirect()->back()->with('success', $response['message']);
                } else {
                    return redirect()->back()->withInput()->with('success', $response['message']);
                }
            } catch(\Exception $e) {
                return redirect()->back()->with(['dismiss' => $e->getMessage()]);
            }
        }
    }

    public function adminSavePaymentSettings(Request $request)
    {
        if ($request->post()) {
            $rules = [
                'COIN_PAYMENT_PUBLIC_KEY' => 'required',
                'COIN_PAYMENT_PRIVATE_KEY' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $errors = [];
                $e = $validator->errors()->all();
                foreach ($e as $error) {
                    $errors[] = $error;
                }
                $data['message'] = $errors;
                return redirect()->back()->with(['dismiss' => $errors[0]]);
            }

            try {
                $response = $this->settingRepo->savePaymentSetting($request);
                if ($response['success'] == true) {
                    return redirect()->back()->with('success', $response['message']);
                } else {
                    return redirect()->back()->withInput()->with('success', $response['message']);
                }
            } catch(\Exception $e) {
                return redirect()->back()->with(['dismiss' => $e->getMessage()]);
            }
        }
    }

    public function apiServicPage()
    {
        $data['settings'] = settings(['CURRENCY_EXCHANGE_RATE_API_KEY', 'CRYPTO_COMPARE_API_KEY']);
        return view('setting.api_service', $data);
    }
}
