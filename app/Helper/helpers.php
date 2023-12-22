<?php

use App\Models\Role;
use App\Models\AdminSetting;
use App\Http\Services\Logger;
use App\Models\Coin;
use App\Models\CurrencyList;
use App\Models\WithdrawHistory;
use App\Models\DepositeTransaction;
use App\Models\Wallet;
use App\Models\WalletAddressHistory;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;



function makeUniqueId()
{
    return uniqid().date('').time();
}

function checkRolePermission($role_task, $my_role)
{
    if(Auth::user()->role_module == ROLE_SUPER_ADMIN)
    return 1;
    $role = Role::findOrFail($my_role);
    if (!empty($role->actions)) {
        if (!empty($role->actions)) {
            $tasks = array_filter(explode('|', $role->actions));
        }
        if (isset($tasks)) {
            if (in_array($role_task, $tasks)) {
                return 1;
            } else {
                return 0;
            }
        }
    }
    return 0;
}


/**
 * @param int $a
 * @return string
 */
// random number
function randomNumber($a = 10)
{
    $x = '123456789';
    $c = strlen($x) - 1;
    $z = '';
    for ($i = 0; $i < $a; $i++) {
        $y = rand(0, $c);
        $z .= substr($x, $y, 1);
    }
    return $z;
}



/**
 * @param null $array
 * @return array|bool
 */
function allsetting($array = null)
{
    if (!isset($array[0])) {
        $allsettings = AdminSetting::get();
        if ($allsettings) {
            $output = [];
            foreach ($allsettings as $setting) {
                $output[$setting->slug] = $setting->value;
            }
            return $output;
        }
        return false;
    } elseif (is_array($array)) {
        $allsettings = AdminSetting::whereIn('slug', $array)->get();
        if ($allsettings) {
            $output = [];
            foreach ($allsettings as $setting) {
                $output[$setting->slug] = $setting->value;
            }
            return $output;
        }
        return false;
    } else {
        $allsettings = AdminSetting::where(['slug' => $array])->first();
        if ($allsettings) {
            $output = $allsettings->value;
            return $output;
        }
        return false;
    }
}

if (!function_exists('settings')) {

    function settings($keys = null)
    {
        if ($keys && is_array($keys)) {
            return AdminSetting::whereIn('slug', $keys)->pluck('value', 'slug')->toArray();
        } elseif ($keys && is_string($keys)) {
            $setting = AdminSetting::where('slug', $keys)->first();
            return empty($setting) ? false : $setting->value;
        }
        return AdminSetting::pluck('value', 'slug')->toArray();
    }
}


function storeException($type,$message)
{
    $logger = new Logger();
    $logger->log($type,$message);
}

function responseData($status,$message='',$data=[])
{
    $message = !empty($message) ? $message : __('Something went wrong');
    return ['success' => $status,'message' => $message, 'data' => $data];
}


function uploadImage($new_file, $path, $old_file_name = null, $width = null, $height = null)
{
    try{
        if (!file_exists(public_path($path))) {
            mkdir(public_path($path), 0777, true);
        }
        if (isset($old_file_name) && $old_file_name != "" && file_exists($path . $old_file_name)) {
            unlink($path . $old_file_name);

        }
        if ($new_file == '') return false;
        $input['imagename'] = uniqid() . time() . '.' . $new_file->getClientOriginalExtension();
        $imgPath = public_path($path . $input['imagename']);

        $makeImg = Image::make($new_file);
        if ($width != null && $height != null && is_int($width) && is_int($height)) {
            $makeImg->resize($width, $height);
            $makeImg->fit($width, $height);
        }
        // if(ResizeImage::make($new_file)
        //     ->resize($width, $height)
        //     ->save($path . $input['imagename'])) {
        //         return $input['imagename'];
        //     }



        if ($makeImg->save($imgPath)) {
            return $input['imagename'];
        }
        return false;
    }catch(\Exception $e){
        storeException('uploadFilep2p helper', $e->getMessage());
        return '';
    }

}


function imageSrcUser($path,$image="")
{
    $return = asset('assets/images/avatar.jpg');
    if (isset($image) && $image !== "" && file_exists(public_path($path . '/' . $image))) {
        $return = asset($path . '/' . $image);
    }
    return $return;
}

function uploadFileStorage($new_file, $path, $old_file_name = null, $width = null, $height = null)
{
    try{
        if ($new_file == '') return false;
        if (isset($old_file_name) && $old_file_name != "" ) {
            $fileExists = Storage::disk('local')->exists($path.$old_file_name);
            if($fileExists) {
                Storage::delete($path.$old_file_name);
            }
        }

        // Get filename with the extension
        $filenameWithExt = $new_file->getClientOriginalName();
        //Get just filename
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        // Get just ext
        $extension = $new_file->getClientOriginalExtension();
        // Filename to store
        $fileNameToStore = uniqid().'_'.time().'.'.$extension;
        $new_file->storeAs($path,$fileNameToStore,'public');

        return $fileNameToStore;
    } catch(\Exception $e) {
        storeException('uploadFileStorage helper', $e->getMessage());
        return false;
    }

}

function showUserImage($path,$image)
{
    $return = asset('assets/images/avatar.jpg');
    if (isset($image) && $image !== "" ) {
        // $fileExists = Storage::disk('public')->exists($path.$image);
        // if($fileExists) {
            $return = asset($path . $image);
        // }
    }
    return $return;
}

function showImage($path,$image)
{
    $return = '';
    if (isset($image) && $image !== "" ) {
        // $fileExists = Storage::disk('local')->exists($path.$image);
        // if($fileExists) {
            $return = asset($path . $image);
    //     }
    }
    return $return;
}

function showDefaultImage($path,$image)
{
    $return = asset('assets/images/placeholder-image.png');
    if (isset($image) && $image !== "" ) {
        // $fileExists = Storage::disk('public')->exists($path.$image);
        // if($fileExists) {
            $return = asset($path . $image);
        // }
    }
    return $return;
}

function decryptId($encryptedId)
{
    try {
        $id = decrypt($encryptedId);
    } catch (Exception $e) {
        storeException('decryptId',$e->getMessage());
        return ['success' => false];
    }
    return $id;
}

function find_coin_type($coin_type)
{
    $type = $coin_type;
    if ($coin_type == 'Default') {
        $type = settings('coin_name');
    }

    return $type;
}

function checkCoinDeleteCondition($coin)
{
    $response = ['success' => true, 'message' => __('Success')];
//    $checkCoinWalletBalance = checkWalletBalanceByCoin($coin->id);
//    if ($checkCoinWalletBalance > 0) {
//        return ['success' => false, 'message' => __('This coin wallet already have some balance, so you should not delete this coin.')];
//    }
    $checkCoinWalletAddress = checkWalletAddressByCoin($coin->coin_type);
    if ($checkCoinWalletAddress > 0) {
        return ['success' => false, 'message' => __('This coin wallet already have some address, so you should not delete this coin.')];
    }

    $checkCoinDeposit = checkDepositByCoin($coin->coin_type);
    if ($checkCoinDeposit > 0) {
        return ['success' => false, 'message' => __('This coin already have some deposit, so you should not delete this coin')];
    }
    $checkCoinWithdrawal = checkWithdrawalByCoin($coin->coin_type);
    if ($checkCoinWithdrawal > 0) {
        return ['success' => false, 'message' => __('This coin already have some withdrawal, so you should not delete this coin')];
    }
    return $response;
}

function checkWithdrawalByCoin($coinType)
{
    $item = WithdrawHistory::where(['coin_type' => $coinType])->get();
    if (isset($item[0])) {
        return 1;
    }
    return 0;
}

function checkDepositByCoin($coinType)
{
    $item = DepositeTransaction::where(['coin_type' => $coinType])->get();
    if (isset($item[0])) {
        return 1;
    }
    return 0;
}

function checkWalletAddressByCoin($coinType)
{
    return WalletAddressHistory::where(['coin_type' => $coinType])->count();
}

function responseJsonData($status,$message='',$data=[])
{
    $message = !empty($message) ? $message : __('Something went wrong');
    return response()->json(['success' => $status,'message' => $message, 'data' => $data]);
}


// create user wallet
function createUserWallet($userId) {
    $coins = Coin::where(['status' => STATUS_ACTIVE])->get();
    if (isset($coins[0])) {
        foreach($coins as $coin) {
            Wallet::firstOrCreate(['user_id' => $userId, 'coin_id' => $coin->id],[
                'name' => $coin->coin_type.' Wallet',
                'coin_type' => $coin->coin_type
            ]);
        }
    }
}

// convert currency
function convert_currency($from, $to, $amount){
    $returnAmount = 0;
    try {
        $fromCoin = Coin::where(['coin_type' => $from])->first();
        if(empty($fromCoin)) {
            $fromCoin = CurrencyList::where(['code' => $from])->first();
        }

        $toCoin = Coin::where(['coin_type' => $to])->first();
        if(empty($toCoin)) {
            $toCoin = CurrencyList::where(['code' => $to])->first();
        }
        if (isset($fromCoin) && ($to == 'USD' || $to == 'USDT' || $to == 'USDC')) {
            $returnAmount = bcmul($fromCoin->usd_rate,$amount,8);
            return $returnAmount;
        } 
        if (isset($toCoin) && ($from == 'USD' || $from == 'USDT' || $from == 'USDC')) {
            $returnAmount = bcmul(bcdiv(1,$toCoin->usd_rate,8),$amount,8);
            return $returnAmount;
        } 
        $returnAmount = bcmul(bcdiv($fromCoin->usd_rate,$toCoin->usd_rate,8),$amount,8);
    } catch(\Exception $e) {
        storeException('convert_currency', $e->getMessage());
    }
    return $returnAmount;
}