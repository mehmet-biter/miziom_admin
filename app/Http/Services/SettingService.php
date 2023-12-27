<?php
namespace App\Http\Services;

use App\Models\AdminSetting;
use Illuminate\Support\Facades\DB;

class SettingService
{
    
    public function saveAdminSetting($request)
    {
        $response = responseData(false);
        DB::beginTransaction();
        try {
            foreach ($request->except('_token') as $key => $value) {

                if ($request->hasFile($key)) {
                    $image = uploadFileStorage($request->$key, IMAGE_SETTING_PATH, isset(allsetting()[$key]) ? allsetting()[$key] : '');
                    AdminSetting::updateOrCreate(['slug' => $key],['slug' => $key, 'value' => $image]);
                } else {
                    AdminSetting::updateOrCreate(['slug' => $key],['slug' => $key, 'value' => $value]);
                }
            }

            $response = responseData(true,__('Setting updated successfully'));
            DB::commit();
        } catch (\Exception $e) {
            storeException('saveAdminSetting ex --> ', $e->getMessage());
            DB::rollBack();
        }
        
        return $response;
    }

    public function saveEmailSetting($request)
    {
        $response = ['success' => false, 'message' => __('Invalid request')];
        DB::beginTransaction();
        try {

            if (isset($request->mail_driver)) {
                AdminSetting::updateOrCreate(['slug' => 'mail_driver'], ['value' => $request->mail_driver]);
            }
            if (isset($request->mail_host)) {
                AdminSetting::updateOrCreate(['slug' => 'mail_host'], ['value' => $request->mail_host]);
            }
            if (isset($request->mail_port)) {
                AdminSetting::updateOrCreate(['slug' => 'mail_port'], ['value' => $request->mail_port]);
            }
            if (isset($request->mail_username)) {
                AdminSetting::updateOrCreate(['slug' => 'mail_username'], ['value' => $request->mail_username]);
            }
            if (isset($request->mail_password)) {
                AdminSetting::updateOrCreate(['slug' => 'mail_password'], ['value' => $request->mail_password]);
            }
            if (isset($request->mail_encryption)) {
                AdminSetting::updateOrCreate(['slug' => 'mail_encryption'], ['value' => $request->mail_encryption]);
            }
            if (isset($request->mail_from_address)) {
                AdminSetting::updateOrCreate(['slug' => 'mail_from_address'], ['value' => $request->mail_from_address]);
            }
            if (isset($request->MAILGUN_DOMAIN)) {
                AdminSetting::updateOrCreate(['slug' => 'MAILGUN_DOMAIN'], ['value' => $request->MAILGUN_DOMAIN]);
            }
            if (isset($request->MAILGUN_DOMAIN)) {
                AdminSetting::updateOrCreate(['slug' => 'MAILGUN_DOMAIN'], ['value' => $request->MAILGUN_DOMAIN]);
            }
            if (isset($request->MAILGUN_SECRET)) {
                AdminSetting::updateOrCreate(['slug' => 'MAILGUN_SECRET'], ['value' => $request->MAILGUN_SECRET]);
            }
            $response = [
                'success' => true,
                'message' => __('Email setting updated successfully')
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            storeException("saveEmailSetting", $e->getMessage());
            $response = [
                'success' => false,
                'message' => __('Something went wrong')
            ];
            return $response;
        }
        DB::commit();
        return $response;
    }
}
