<?php

namespace App\Http\Services;

use Exception;
use App\Models\Coin;
use GuzzleHttp\Client;
use App\Models\CurrencyList;
use App\Jobs\UpdateCoinRateUsd;
use Illuminate\Support\Facades\DB;
use App\Model\FiatWithdrawalCurrency;

class CurrencyService
{

    public $response;
    function __construct()
    {

    }

    /**
     * @param $request
     * @return array
     */
    // marketplace data
    public function currencyList()
    {
        return CurrencyList::orderBy('id', 'desc')->get();
    }

    public function getActiveCurrencyList()
    {
        return CurrencyList::where('status',STATUS_ACTIVE)->orderBy('id', 'desc')->get();
    }

    public function currencyAddEdit($request,$auto = false){
        DB::beginTransaction();
        try {
            $response = isset($request->id) ? __("Currency updated ") : __("Currency created ") ;
            $id = $request->id ?? 0;
            $status =  isset($request->status) ? true : false;
            $check = $auto ? [ 'code' => $request->code ] : [ 'id' => $id ] ;
            CurrencyList::updateOrCreate($check,[
                'name' => $request->name,
                'code' => $request->code,
                'symbol' => $request->symbol,
                'usd_rate' => $request->rate,
                'status' => $status,
            ]);
        }catch (Exception $e){
            DB::rollBack();
            storeException("Currency Add Edit",$e->getMessage());
            return ["success" => false, "message" => $response . __("failed")];
        }
        DB::commit();
        return ["success" => true, "message" => $response . __("successfully")];
    }

    public function saveAllCurrency(){
        $currency = fiat_currency_array();
        foreach ($currency as $item){
            if(!isset($item['rate']))
                $item['rate'] = 1;
                $item['status'] = 1;
            $respose = $this->currencyAddEdit((object)$item, true);
        }
        $responseCurrencyExchangeRate = $this->getCurrencyRateData();

        if($responseCurrencyExchangeRate['success'])
        {
            $rates = $responseCurrencyExchangeRate['data'];
            if($rates['rates']) {
                foreach ($rates['rates'] as $type => $rate){
                    foreach ($currency as $index => $item){
                        if($item['code'] == $type)
                            $currency[$index]['rate'] = $rate;
                    }
                }
            }
            foreach ($currency as $item){
                if(!isset($item['rate']))
                    $item['rate'] = 1;
                    $item['status'] = 1;
                $respose = $this->currencyAddEdit((object)$item, true);
            }
        }
    }

    public function currencyStatusUpdate($id){
        DB::beginTransaction();
        try{
            if($c = CurrencyList::find($id)){
                $status = !$c->status;
                if($c->update(['status' => $status])){
                    DB::commit();
                    return responseData(true, __("Status updated successfully"));
                }
                return responseData(false, __("Status failed to update"));
            }
            return responseData(false, __("Currency not found"));
        }catch (Exception $e){
            DB::rollBack();
            storeException("Currency Status Changed",$e->getMessage());
            return responseData(false, __("Something went wrong"));
        }
    }

    public function currencyRateSave(){
        $responseCurrencyExchangeRate = $this->getCurrencyRateData();
        DB::beginTransaction();
        try{

            if($responseCurrencyExchangeRate['success'])
            {
                $data = $responseCurrencyExchangeRate['data']['rates'] ?? [];
                if($data) {
                    foreach ($data as $type => $rate){
                        $usd = (is_numeric($rate) && $rate > 0 ) ? bcdiv(1,number_format($rate, 8,".",""),4) : $rate;
                        if($coin = Coin::where("coin_type", $type)->first()){
                            $coin->update(['usd_rate' => $usd]);
                        }
                        CurrencyList::where('code',$type)->update([ 'usd_rate' => $rate ? $rate : 1 ]);
                    }
                }

            }else{
                $this->response = $responseCurrencyExchangeRate;
                return;
            }

        }catch (Exception $e){
            storeException('currencyRateSave', $e->getMessage());
            DB::rollBack();
            $this->response = [ 'success' => false, 'message' => __('Currency Rate Update failed') ];
        }
        DB::commit();
        $this->response = [ 'success' => true, 'message' => __('Currency Rate Update') ];
    }
    public function getCurrencyRateData(){
        $apiKey = allsetting('CURRENCY_EXCHANGE_RATE_API_KEY')??null;
        if($apiKey){
            $headers = ['Content-Type: application/json'] ;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://openexchangerates.org/api/latest.json?app_id='.$apiKey);
            curl_setopt($ch, CURLOPT_POST, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $result = curl_exec($ch);
            curl_close($ch);

            $responseData = json_decode($result,true);
            if(isset($responseData['error']))
            {
                return responseData(false, $responseData['message'], $responseData);
            }else{
                return responseData(true, __('Currency exchange rate list'), $responseData);
            }

        }else{
            return responseData(false, __('API key is not set!'));
        }

    }

    public function updateCoinRate(){
        try{
            $coins = Coin::where(['status' => STATUS_ACTIVE])->get();
           if(isset($coins[0])) {
               dispatch(new UpdateCoinRateUsd($coins));
           }
        }catch (\Exception $e){
            storeException("Update Coin Rate",$e->getMessage());
            return [ "success" => false, "message" => __("Coins rate updated Failed") ];
        }
        return [ "success" => true, "message" => __("Coins rate update process started successfully, It will take some time") ];
    }

    public function getPriceFromApi($coin)
    {
        $response = responseData(false);
        try {
            $client = new Client();
            $api_key = settings('CRYPTO_COMPARE_API_KEY') ?? '';
            $callApi = $client->get("https://min-api.cryptocompare.com/data/price?fsym=$coin&tsyms=USD&api_key=$api_key");
            $getBody = json_decode($callApi->getBody(), true);
            if (!empty($getBody)) {
                $response = responseData(true,__('Success'),$getBody['USD'] ?? 0);
            } else {
                storeException('callAskBidApi '.$coin,'api has no data');
                $response = responseData(false,__('Api has no data'));
            }
        } catch (Exception $e) {
            storeException('getPriceFromApi ex -> '.$coin,$e->getMessage());

            $response = responseData(false,$e->getMessage());
        }
        return $response;
    }
    public function updateCoinRateCorn(){
        try{
           $coins = Coin::where(['currency_type' => CURRENCY_TYPE_CRYPTO,'status' => STATUS_ACTIVE])->get();
           if(isset($coins[0])) {
              foreach ($coins as $coin){
                  $coin_type = explode('.',$coin->coin_type)[0];
                  $res = $this->getPriceFromApi($coin_type);
                  if(isset($res['success']) && $res['success']){
                    $res = number_format(($res['data'] ?? 0),8,'.','');
                    $coin->usd_rate = $res;
                    $coin->save();
                  }
              }
           }
           $this->currencyRateSave();
        }catch (Exception $e){
            storeException("Update Coin Rate",$e->getMessage());
            return [ "success" => false, "message" => __("Coins rate updated Failed") ];
        }
        return [ "success" => true, "message" => __("Coins rate update process started successfully, It will take some time") ];
    }


    public function withdrawalCurrencyStatusUpdate($id)
    {
        DB::beginTransaction();
        try{
            $c = FiatWithdrawalCurrency::find($id);
            $status = !$c->status;
            $c->update(['status' => $status]);
        }catch (\Exception $e){
            DB::rollBack();
            storeException($e,"withdrawal Currency Status Changed",$e->getMessage());
            return false;
        }
        DB::commit();
        return true;
    }

    public function withdrawalCurrencySaveProcess($request)
    {
        $response = responseData(false);
        try {
            if ($request->currency_id) {
                $exist = FiatWithdrawalCurrency::where(['currency_id' => $request->currency_id])->first();
                if ($exist) {
                    $response = responseData(false,__('Currency already added'));
                } else {
                    FiatWithdrawalCurrency::firstOrCreate(['currency_id' => $request->currency_id],['status' => STATUS_ACTIVE]);
                    $response = responseData(false,__('Currency added successfully'));
                }
            } else {
                $response = responseData(false,__('Currency is required'));
            }
        } catch (\Exception $e) {
            storeException('withdrawalCurrencySaveProcess',$e->getMessage());
        }
        return $response;
    }

    public function withdrawalCurrencyDeleteProcess($id)
    {
        $response = responseData(false);
        try {
            FiatWithdrawalCurrency::findOrFail($id)->delete();
            $response = responseData(true,__('Deleted successfully'));
        } catch (\Exception $e) {
            storeException('withdrawalCurrencyDeleteProcess',$e->getMessage());
        }
        return $response;
    }
}
