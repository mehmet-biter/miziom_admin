<?php
namespace App\Http\Services;

use App\Models\Coin;
use App\Models\Wallet;
use App\Models\CoinSetting;
use Illuminate\Support\Facades\DB;
use App\Http\Repository\AdminCoinRepository;

class CoinService extends BaseService {

    public $repository;
    public function __construct()
    {
        $this->repository =  new AdminCoinRepository();
        parent::__construct($this->repository);

    }

    public function getCoin($data){
        $repository = $this->repository->getDocs($data);

        if (empty($repository)) {
            return null;
        }

        return $repository;
    }

    public function getCoinListActive()
    {
        try{
            $data = $this->repository->getWhere(['status' => STATUS_ACTIVE]);
            $response = ['success' => true, 'message' => __('Active Coin list!'), 'data'=>$data];
        }catch (\Exception $e) {
            storeException("getCoinListActive",$e->getMessage());
            $response = ['success' => true, 'message' => __('Something went wrong!')];
        }
        return $response;
    }


    public function addCoin($data,$coin_id=null){
        try{

            if(!empty($coin_id)){
                $coinData = Coin::find($coin_id);
                if ($coinData->coin_type != $data['coin_type']) {
                    if ($coinData->coin_type == 'BTC' || $coinData->coin_type == 'USDT') {
                        return ['success'=>false,'data' => "",'message'=> __('You can not change this coin, because this is on of the base coin')];
                    }
                    $checkType = checkCoinTypeUpdateCondition($coinData);
                    if ($checkType['success'] == false) {
                        return ['success'=>false,'data' => "",'message'=> $checkType['message']];
                    }
                }
                if ($coinData->network != $data['network']) {
                    $checkNetwork = checkCoinNetworkUpdateCondition($coinData);
                    if ($checkNetwork['success'] == false) {
                        return ['success'=>false,'data' => "",'message'=> $checkNetwork['message']];
                    }
                }
                $coin = $this->repository->updateCoin($coin_id,$data);
                if ($coinData->coin_type != $data['coin_type']) {
                    Wallet::where(['coin_id' => $coinData->id])->update(['coin_type' => $data['coin_type'], 'name' => $data['coin_type'].' wallet']);
                }
            }else{
//                if (empty($data['coin_icon'])) {
//                    return ['success' => false, 'message' => 'Coin icon can not be empty.'];
//                }
                $coin = $this->repository->addCoin($data);
            }

            return ['success'=>true,'data'=>$coin,'message'=>__('updated successful.')];
        } catch(\Exception $e) {
            storeException("coin update", $e->getMessage());
            return ['success'=>false,'data'=>null,'message'=>'something.went.wrong'];
        }
    }

    public function getCoinDetailsById($coinId){
        try{
            $coin = $this->repository->whereFirst(['id' => $coinId]);
            if($coin) {
                return ['success'=>true,'data'=>$coin,'message'=>'successfull.'];
            } else {
                return ['success'=>false,'data'=>'','message'=>__('Data not found')];
            }
        }catch(\Exception $e){
            return ['success'=>false,'data'=>null,'message'=>'something.went.wrong'];
        }
    }

    // admin coin delete
    public function adminCoinDeleteProcess($coinId)
    {
        $response = ['success' => false, 'message' => __('Something went wrong'), 'data' => []];
        DB::beginTransaction();
        try {
            $coin = Coin::find($coinId);
            if ($coin) {
                if ($coin->coin_type == 'BTC' || $coin->coin_type == 'USDT') {
                    return ['success' => false, 'message' => __('You never delete this coin, because this is on of the base coin '), 'data' => []];
                }
                $check = checkCoinDeleteCondition($coin);
                if ($check['success'] == true) {
                    $coin->delete();
                    Wallet::where(['coin_id' => $coin->id])->delete();
                    $response = ['success' => true, 'message' => __('Coin deleted successfully'), 'data' => []];
                } else {
                    $response = ['success' => false, 'message' => $check['message'], 'data' => []];
                }
            } else {
                $response = ['success' => false, 'message' => __('Coin not found'), 'data' => []];
            }
        } catch (\Exception $e) {
            DB::rollBack();
            storeException('adminCoinDeleteProcess', $e->getMessage());
        }
        DB::commit();
        return $response;
    }

    public function deleteWebhook($service,$coin,$request){
        return $service->removeWalletWebhook($coin->coin_type,$coin->bitgo_wallet_id,$request->type,$coin->bitgo_webhook_url,$coin->bitgo_webhook_id);
    }

    // add webhook
    public function webhookSaveProcess($request)
    {
        try {

            $coin = Coin::join('coin_settings','coins.id','=','coin_settings.coin_id')->where(['coin_settings.coin_id' => decrypt($request->coin_id)])->first();
            if (isset($coin)) {
                if(empty($coin->bitgo_wallet_id)){
                    $response = [
                        'success' => false,
                        'message' => __("Your Bitgo wallet id not set yet !!"),
                        'data' => ""
                    ];
                    return $response;
                }
                $bitgoApi =  new BitgoWalletService();
                if(($request->url !== $coin->bitgo_webhook_url || $request->numConfirmations !== $coin->bitgo_webhook_numConfirmations) && !empty($coin->bitgo_webhook_url)){
                    $response = $this->deleteWebhook($bitgoApi,$coin,$request);
                    if(!$response["success"]){
                        return $response;
                    }
                }
                $allToken = $request->allToken == 1 ? true : false;
                $bitgoResponse = $bitgoApi->addWebhook($coin->coin_type,$coin->bitgo_wallet_id,$request->type,$allToken,$request->url,$request->label,intval($request->numConfirmations));
                if (!$bitgoResponse['success']) {
                    storeException('Bitgo webhookSaveProcess', $bitgoResponse['message']);
                    $response = [
                        'success' => false,
                        'message' => $bitgoResponse['message'],
                        'data' => ""
                    ];
                    return $response;
                }
                $coin = CoinSetting::where(['coin_settings.coin_id' => decrypt($request->coin_id)])->update([
                    'bitgo_webhook_label' => $request->label,
                    'bitgo_webhook_type' => $request->type,
                    'bitgo_webhook_url' => $request->url,
                    'bitgo_webhook_numConfirmations' => $request->numConfirmations,
                    'bitgo_webhook_allToken' => $request->allToken,
                    'bitgo_webhook_id' => $bitgoResponse['data']["id"],
                    'webhook_status' => STATUS_ACTIVE
                ]);
                $response = [
                    'success' => true,
                    'message' => __('Webhook updated successful'),
                    'data' => $bitgoResponse
                ];
            } else {
                $response = [
                    'success' => false,
                    'message' => __('Coin not found'),
                    'data' => []
                ];
            }
        } catch (\Exception $e) {
            storeException('webhookSaveProcess: ', $e->getMessage());
            $response = [
                'success' => false,
                'message' => __('Something went wrong'),
                'data' => ""
            ];
        }
        return $response;
    }

    public function getAllActiveCoinList()
    {
        $coin_list = Coin::where('status', '<>', STATUS_DELETED)
                            ->where('ico_id','=',0)
                            ->orWhere('is_listed',STATUS_ACTIVE)->orderBy('id','asc')->get();
        
        $response = ['success'=>true, 'message'=>__('Active Coin List'), 'data'=>$coin_list];

        return $response;
    }

    public function updateWalletKey($request)
    {
        $id = decrypt($request->id);

        $coinSettingDetails = CoinSetting::find($id);
        if(isset($coinSettingDetails))
        {
            $coinSettingDetails->wallet_key = encrypt($request->wallet_key);
            $coinSettingDetails->save();

            $response = responseData(true, 'Wallet Key is updated successfully!');

        }else{
            $response = responseData(false, __('Coin Settings not found!'));
        }

        return $response;
    }

    public function viewWalletKey($request)
    {
        $user = auth()->user();

        if(!isset($request->id))
        {
            return responseData(false, __('Invalid Request!'));
        }

        if(!isset($request->password))
        {
            return responseData(false, __('Enter Your Password!'));
        }

        $user_details = User::find($user->id);

        if(isset($user_details))
        {
            if(Hash::check($request->password, $user_details->password))
            {
                $coinSettingDetails = CoinSetting::find(decrypt($request->id));
                if(isset($coinSettingDetails) && isset($coinSettingDetails->wallet_key))
                {
                    return responseData(true, __('Wallet Key details'), decrypt($coinSettingDetails->wallet_key));
                }else{
                    return responseData(false, __('Wallet key not found!'));
                }
            }else{
                return responseData(false, __('Invalid Password!'));
            }

        }else{
            return responseData(false, __('User Details not found!'));
        }

        
    }

}