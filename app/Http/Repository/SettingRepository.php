<?php
namespace App\Http\Repository;

use App\Models\AdminSetting;
use Illuminate\Support\Facades\DB;


class SettingRepository
{
    public function saveBitgoSetting($request)
    {
        $response = ['success' => false, 'message' => __('Invalid request')];
        DB::beginTransaction();
        try {
            AdminSetting::updateOrCreate(['slug' => 'bitgo_api'], ['value' => $request->bitgo_api]);
            AdminSetting::updateOrCreate(['slug' => 'bitgoExpess'], ['value' => $request->bitgoExpess]);
            AdminSetting::updateOrCreate(['slug' => 'BITGO_ENV'], ['value' => $request->BITGO_ENV]);
            AdminSetting::updateOrCreate(['slug' => 'bitgo_token'], ['value' => $request->bitgo_token]);

            $response = [
                'success' => true,
                'message' => __('Bitgo setting updated successfully')
            ];
        } catch (\Exception $e) {
            DB::rollBack();
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