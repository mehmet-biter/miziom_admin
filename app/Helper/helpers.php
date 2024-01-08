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

require_once('role.php');

function makeUniqueId()
{
    return uniqid().date('').time();
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
            $fileExists = Storage::disk('local')->exists('/public/'.$path.$old_file_name);
            if($fileExists) {
                Storage::delete('/public/'.$path.$old_file_name);
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

function checkCoinNetworkUpdateCondition($coin)
{
    $response = ['success' => true, 'message' => __('Success')];

    $checkCoinWalletAddress = checkWalletAddressByCoin($coin->coin_type);
    if ($checkCoinWalletAddress > 0) {
        return ['success' => false, 'message' => __('This coin network wallet already have some address, so you should not change this coin network.')];
    }
    $checkCoinDeposit = checkDepositByCoin($coin->coin_type);
    if ($checkCoinDeposit > 0) {
        return ['success' => false, 'message' => __('This coin network already have some deposit, so you should not change this coin network')];
    }
    $checkCoinWithdrawal = checkWithdrawalByCoin($coin->coin_type);
    if ($checkCoinWithdrawal > 0) {
        return ['success' => false, 'message' => __('This coin network already have some withdrawal, so you should not change this coin network')];
    }
    return $response;
}

function addressType($input = null){
    $output = [
        ADDRESS_TYPE_INTERNAL => __('Internal'),
        ADDRESS_TYPE_EXTERNAL => __('External'),
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input] ? $output[$input] : null ;
    }
}

function check_withdrawal_fees($amount, $fees_percentage, $type)
{
    return

    $type == DISCOUNT_TYPE_FIXED ? $fees_percentage : bcdiv(bcmul($fees_percentage, $amount,8),100,8);
}

function make_unique_slug($title, $table_name = NULL, $column_name = 'slug')
{
    $table = array(
        'Š' => 'S', 'š' => 's', 'Đ' => 'Dj', 'đ' => 'dj', 'Ž' => 'Z', 'ž' => 'z', 'Č' => 'C', 'č' => 'c', 'Ć' => 'C', 'ć' => 'c',
        'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E',
        'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O',
        'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss',
        'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'a', 'ç' => 'c', 'è' => 'e', 'é' => 'e',
        'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o',
        'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'ý' => 'y', 'þ' => 'b',
        'ÿ' => 'y', 'Ŕ' => 'R', 'ŕ' => 'r', '/' => '-', ' ' => '-'
    );

    // -- Remove duplicated spaces
    $stripped = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $title);

    // -- Returns the slug
    $slug = strtolower(strtr($title, $table));
    $slug = str_replace("?", "", $slug);
    $slug = str_replace("&", "-", $slug);
    $slug = str_replace("%", "-", $slug);
    $slug = str_replace("#", "-", $slug);
    $slug = str_replace("@", "-", $slug);
    $slug = str_replace('--', '-', $slug);
    if (isset($table_name)) {
        $item = DB::table($table_name)->where($column_name, $slug)->first();
        if (isset($item)) {
            $slug = setSlugAttribute($slug, $table_name, $column_name);
        }
    }

    return $slug;
}

function bitgo_divisibility_value($input = null)
    {
        $output = [
            "ADA" => 1000000,
            "ALGO" => 1000000,
            "ATOM" => 1000000,
            "AVAX" => 1000000000000000000,
            "BCH"  => 100000000,
            "BNB" => 1000000000000000000,
            "BTC"  => 100000000,
            "BTG"  => 100000000,
            "CELO" => 1000000000000000000,
            "CSPR" => 1000000000,
            "DASH" => 100000000,
            "DOT" => 10000000000,
            "DOGE" => 100000000,
            "EOS"  => 10000,
            "ETC" => 1000000000000000000,
            "ETH"  => 1000000000000000000,
            "HBAR" => 100000000,
            "LTC"  => 100000000,
            "MATIC" => 1000000000000000000,
            "NEAR" => 1000000000000000000000000,
            "RBTC" => 1000000000000000000,
            "SOL" => 1000000000,
            "STX"  => 1000000,
            "SUI" => 1000000000,
            "TRX"  => 1000000,
            "WBTC" => 100000000,
            "WDOGE" => 100000000,
            "XTZ"  => 1000000,
            "XLM"  => 10000000,
            "XRP"  => 100000000,
            "ZEC"  => 100000000,
            "POLYGON"  => 1000000000000000000,
            "POLYGON:USDCV2" => 1000000,


            // For test net
            "TADA" => 1000000,
            "TALGO" => 1000000,
            "TATOM" => 1000000,
            "TAVAX" => 1000000000000000000,
            "TBCH"  => 100000000,
            "TBNB" => 1000000000000000000,
            "TBTC"  => 100000000,
            "TBTG"  => 100000000,
            "TCELO" => 1000000000000000000,
            "TCSPR" => 1000000000,
            "TDASH" => 100000000,
            "TDOT" => 10000000000,
            "TDOGE" => 100000000,
            "TEOS"  => 10000,
            "TETC" => 1000000000000000000,
            "TETH"  => 1000000000000000000,
            "THBAR" => 100000000,
            "TLTC"  => 100000000,
            "TMATIC" => 1000000000000000000,
            "TNEAR" => 1000000000000000000000000,
            "TRBTC" => 1000000000000000000,
            "TSOL" => 1000000000,
            "TSTX"  => 1000000,
            "TSUI" => 1000000000,
            "TTRX"  => 1000000,
            "TWBTC" => 100000000,
            "TWDOGE" => 100000000,
            "TXTZ"  => 1000000,
            "TXLM"  => 10000000,
            "TXRP"  => 100000000,
            "TZEC"  => 100000000,
        ];
        

        if (is_null($input)) {
            return $output;
        } else {
            $result = 100000000;
            if (isset($output[$input])) {
                $result = $output[$input];
            }
            return $result;
        }
    }