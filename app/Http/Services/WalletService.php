<?php

namespace App\Http\Services;

use DateTime;
use App\Models\Coin;
use App\Models\User;
use App\Models\Wallet;
use Exception;
use Illuminate\Support\Str;
use App\Models\CurrencyList;
use App\Models\WithdrawHistory;
use App\Jobs\WithdrawalProccess;
use Illuminate\Support\Facades\DB;
use App\Models\DepositeTransaction;
use App\Models\WalletAddressHistory;
use Illuminate\Support\Facades\Auth;
use App\Http\Repository\WalletRepository;
use App\Http\Services\BitgoWalletService;

class WalletService extends BaseService
{
    public $repository;
    public function __construct()
    {
        $this->repository =  new WalletRepository();
        parent::__construct($this->repository);

    }

    // coin data
   public function coinList($type) {
        try {
            if($type == CURRENCY_TYPE_BOTH) {
                $items = Coin::where(['status' => STATUS_ACTIVE])->get();
            } else {
                $items = Coin::where(['status' => STATUS_ACTIVE, 'currency_type' => $type])->get();
            }
            if (isset($items[0])) {
                return responseData(true, __('Data get successfully'),$items);
            } else {
                return responseData(false, __('Data not found'));
            }
        } catch(\Exception $e) {
            storeException('coin list ex', $e->getMessage());
            return responseData(false, __('Something went wrong'));
        }
    }

     // user wallet list
   public function userWalletList($userId,$type,$currency) {
     try {
            createUserWallet($userId);
            $items = $this->repository->getUserWalletList($userId,$type,$currency);
            if (isset($items['wallets'][0])) {
                return responseData(true, __('Data get successfully'),$items);
            } else {
                return responseData(false, __('Data not found'));
            }
        } catch(\Exception $e) {
            storeException('userWalletList ex', $e->getMessage());
            return responseData(false, __('Something went wrong'));
        }
    }

// save data
public function saveItemData($request)
{
    $response = responseData(false);
    try {
        $item='';
        if($request->edit_id) {
            $data = $request->except(['_token', 'edit_id','actions']);
            $item = $this->repository->whereFirst(['unique_code' => $request->edit_id]);
            if(empty($item)) {
                return responseData(false,__('Data not found'));
            }
        } else {
            $data = $request->except(['_token','actions']);
            $data['unique_code'] = makeUniqueId();
        }
        if(isset($request->actions[0])){
            $data['actions'] = implode('|', $request->actions);
        } else {
            return responseData(false,__('Must be select atleast one role'));
        }
        if($request->edit_id) {
            $this->repository->update(['id' => $item->id], $data);
            $response = responseData(true,__('Role updated successfully'));
        } else {
            $this->repository->create($data);
            $response = responseData(true,__('New role added successfully'));
        }
    } catch (\Exception $e) {
        
        storeException('save role', $e->getMessage());
    }
    return $response;
}

    public function searcheCustomer($request) {
        try {
            // if(!isset($request->search) && empty($request->search))
            //     return responseData(false, __('Customer not found!'));

            $search = $request->search ?? '';
            $user = User::where(function($q)use($search){
                        return $q->where('name', 'LIKE', "%$search%")
                        ->orWhere('email', 'LIKE', "%$search%")
                        ->orWhere('username', 'LIKE', "%$search%");
                    })
                    ->where('role_module', MODULE_USER)
                    ->get(['id', 'username', 'unique_code', 'name', 'email', 'photo']);

            if($user){
                $user->map(function($u){
                    $u->photo = showUserImage(VIEW_IMAGE_PATH_USER,$u->photo);
                });
            }
            $data['customer'] = $user;

            if(isset($user[0])) return responseData(true, __('Customer get successfully'),$data);
            return responseData(true, __('Customer not found!')); 
        } catch(Exception $e) {
            storeException('searcheCustomer ex', $e->getMessage());
            return responseData(false, __('Something went wrong'));
        }
    }
   
    public function walletWithdrawal($request, $currency) {
        try {
            // check coin type exist
            if(!isset($request->coin_type))
                return responseData(false, __('Coin not found!')); 

            // set coin type in variable
            $coin_type = $request->coin_type;

            $wallet = DB::table('wallets')
                        ->join('coins', 'coins.id', '=', 'wallets.coin_id')
                        ->where('coins.coin_type', '=', $coin_type)
                        ->where('coins.status', '=', STATUS_ACTIVE)
                        ->select('wallets.*', 'coins.*')
                        ->first();
                        
            $rate = convert_currency($wallet->coin_type,$currency,1);
            $wallet->usd_value_rate = $rate;
            $wallet->usd_value = bcmul($rate,$wallet->balance,8);
            $data['wallet'] = $wallet;

            return responseData(true, __('Withdrawal data found!'), $data);
        } catch(\Exception $e) {
            storeException('searcheCustomer ex', $e->getMessage());
            return responseData(false, __('Something went wrong'));
        }
    }

    public function walletDeposit($request, $currency) {
        try {
            // check coin type exist
            if(!isset($request->coin_type))
                return responseData(false, __('Coin type not found!')); 

            // set coin type in variable
            $coin_type = $request->coin_type;

            if(! $coin = Coin::where(['coin_type' => $coin_type, 'status' => STATUS_ACTIVE])->first())
                return responseData(false, __('Coin not found!'));
            
            if(! $wallet = Wallet::where(['coin_id' => $coin->id, 'user_id' => Auth::id()])->first(['id','coin_type','balance','referral_balance']))
                return responseData(false, __('Wallet not found!'));
            
            $walletAddress = null;
            if(! $walletAddress = WalletAddressHistory::where(['wallet_id' => $wallet->id])->first())
            {
                if($address = $this->get_bitgo_address($coin->coin_type)){
                    $addressData = [
                        "user_id"    => Auth::id(),
                        "coin_id"    => $coin->id,
                        "wallet_id"  => $wallet->id,
                        "address"    => $address,
                        "coin_type"  => $coin->coin_type,
                        "network_id" => BITGO_API,
                    ];
                    $walletAddress = WalletAddressHistory::create($addressData);
                }
            }
            $wallet->is_withdrawal        = $coin->is_withdrawal;
            $wallet->minimum_withdrawal   = $coin->minimum_withdrawal;
            $wallet->maximum_withdrawal   = $coin->maximum_withdrawal;
            $wallet->max_send_limit       = $coin->max_send_limit;
            $wallet->withdrawal_fees      = $coin->withdrawal_fees;
            $wallet->withdrawal_fees_type = $coin->withdrawal_fees_type;
            $rate                         = convert_currency($wallet->coin_type,$currency,1);
            $wallet->usd_value_rate       = $rate;
            $wallet->usd_value            = bcmul($rate,$wallet->balance,8);
            $wallet->address              = $walletAddress->address ?? null; 
            $coin->network                = getNetworkType($coin->network_type ?? 0);
            $wallet->coin                 = $coin;
            $data['wallet'] = $wallet;
            $data['memo'] = null;
            
            return responseData(true, __('Wallet deposit data found!'), $data);
        } catch(\Exception $e) {
            storeException('searcheCustomer ex', $e->getMessage());
            return responseData(false, __('Something went wrong'));
        }
    }

    function get_bitgo_address($coin_type)
    {
        try {
            $coin = Coin::join('coin_settings','coin_settings.coin_id', '=', 'coins.id')
                ->where(['coins.coin_type' => $coin_type])
                ->first();
            if ($coin) {
                if (empty($coin->bitgo_wallet_id)) {
                    storeException('get_bitgo_address ', 'bitgo_wallet_id not found');
                    return false;
                } else {
                    $bitgoApi =  new BitgoWalletService();
                    $address = $bitgoApi->createBitgoWalletAddress((getCoinByNetworkType($coin->network_type) ?? $coin->coin_type), $coin->bitgo_wallet_id,$coin->chain);
                    storeException('address bitgo', json_encode($address));
                    if ($address['success']) {
                        return $address['data']['address'];
                    } else {
                        storeException('get_bitgo_address address', $address['message']);
                        return false;
                    }
                }
            } else {
                storeException('get_bitgo_address ', ' Coin not found');
                return false;
            }
        } catch (\Exception $e) {
            storeException('get_bitgo_address ', $e->getMessage());
        }
    }

    private function makeWithdrawalHistory($user, $request, $wallet, $amount, $currencyAmount, $rate, $defaultCurrency, $fees)
    {
        $address_type = ADDRESS_TYPE_INTERNAL;
        $receiver_wallet = null;

        if(isset($request->customer_id)) {
            $customer = User::find($request->customer_id);
            $receiver_wallet = Wallet::where(['user_id'=> $customer->id, 'coin_type'=> $wallet->coin_type])->first();
        }

        if(!isset($request->customer_id) && (isset($request->address) && !empty($request->address))){
            if( $addressHistory = WalletAddressHistory::where('address', $request->address)->first()){
                $receiver_wallet = Wallet::where(['id' => $addressHistory->wallet_id, 'user_id'=> $customer->user_id])->first();
            }else{
                $address_type = ADDRESS_TYPE_EXTERNAL;
            }
        }
        return [
            "user_id"              => $user->id,
            "wallet_id"            => $wallet->id,
            "amount"               => $amount,
            "currency_amount"      => $currencyAmount,
            "rate"                 => $rate,
            "address_type"         => $address_type,
            "address"              => $request->address ?? '',
            "transaction_hash"     => Str::random(32),
            "coin_type"            => $wallet->coin_type,
            "receiver_wallet_id"   => $receiver_wallet->id ?? NULL,
            "currency_type"        => $defaultCurrency,
            // "used_gas"             => 0,
            "confirmations"        => 1,
            "fees"                 => $fees,
            "for"                  => $request->for ?? 0,
            "status"               => 0,
            // "updated_by"           => 0,
            // "automatic_withdrawal" => 0,
            "network_type"         => $wallet->network,
            'memo'                 => $request->memo ? $request->memo : ''
        ];
    }

    public function walletWithdrawalProccessRequest($request)
    {
        try{
            $user = Auth::user();
            $wallet = Wallet::join('coins', 'coins.id', '=', 'wallets.coin_id')
                    ->where(['wallets.id'=>$request->wallet_id, 'wallets.user_id'=> $user->id, 'coins.is_withdrawal' => STATUS_ACTIVE])
                    ->select('wallets.*', 'coins.status as coin_status', 'coins.is_withdrawal', 'coins.minimum_withdrawal',
                        'coins.maximum_withdrawal', 'coins.withdrawal_fees', 'coins.max_send_limit','coins.withdrawal_fees_type','coins.network')
                    ->first();

            if(!$wallet) return responseData(false, __('Wallet not found!'));

            $currencyAmount = $request->amount;
            $amount = $request->amount;
            $rate = 0;
            $fees = 0;
            $defaultCurrency = settings('default_currency') ?? "NGN";

            if($request->type == WITHDRAWAL_CURRENCY_TYPE_CRYPTO){
                $fees = check_withdrawal_fees($amount, $wallet->withdrawal_fees,$wallet->withdrawal_fees_type);
                $rate = convert_currency($wallet->coin_type, $defaultCurrency, 1);
                $currencyAmount = $amount * $rate;
                $totalAmount = $amount + $fees;
                if( !($wallet->balance >= $totalAmount))
                    return responseData(false, __('Insufficient balance for withdrawal request!'));
            }else{

                $rate = convert_currency($defaultCurrency, $wallet->coin_type, 1);
                $amount = ($amount * $rate);
                $fees = check_withdrawal_fees($amount, $wallet->withdrawal_fees,$wallet->withdrawal_fees_type);
                $totalAmount = $amount + $fees;
                if( !($wallet->balance >= $totalAmount))
                    return responseData(false, __('Insufficient balance for withdrawal request!'));
            }

            if($amount < $wallet->minimum_withdrawal)
                return responseData(false, __('Minimum withdrawal coin amount is :coin', [ 'coin' => $wallet->minimum_withdrawal ]));
            if($amount > $wallet->maximum_withdrawal)
                return responseData(false, __('Maximum withdrawal coin amount is :coin', [ 'coin' => $wallet->maximum_withdrawal ]));

            if(isset($request->customer_id)){
                if(! $customer = User::find($request->customer_id))
                    return responseData(false, __('Customer not found!'));
            }

            $withdrawalHistory = $this->makeWithdrawalHistory($user, $request, $wallet, $amount, $currencyAmount, $rate, $defaultCurrency, $fees);
            if($withdrawalHistoryData = WithdrawHistory::create($withdrawalHistory))
            {
                WithdrawalProccess::dispatch($withdrawalHistoryData->id, $request->customer_id ?? null)->onQueue("withdrawal-proccess");
                return responseData(true, __('Your withdrawal request has been submitted successfully.'));
            }
            return responseData(false, __('Your withdrawal request failed.'));
        } catch (\Exception $e) {
            storeException("walletWithdrawalProccessRequest", $e->getMessage() . $e->getLine());
            return responseData(false, __('Something went wrong!'));
        }
    }
    public function walletWithdrawalProccess($withdrawalHistory)
    {
        try{
            $wallet = Wallet::join('coins', 'coins.id', '=', 'wallets.coin_id')
                    ->where(['wallets.id'=>$withdrawalHistory->wallet_id, 'wallets.user_id'=> $withdrawalHistory->user_id, 'coins.is_withdrawal' => STATUS_ACTIVE])
                    ->select('wallets.*', 'coins.status as coin_status', 'coins.is_withdrawal', 'coins.minimum_withdrawal',
                        'coins.maximum_withdrawal', 'coins.withdrawal_fees', 'coins.max_send_limit','coins.withdrawal_fees_type','coins.network')
                    ->first();

            if(!$wallet){
                storeException("walletWithdrawalProccess", "withdrawal history id: $withdrawalHistory->id --- wallet not found");
                return;
            }

            $amount = $withdrawalHistory->amount + $withdrawalHistory->fees;

            if(isset($withdrawalHistory->customer_id) && $withdrawalHistory->customer_id){
                if(! $customer = User::find($withdrawalHistory->customer_id)){
                    storeException("walletWithdrawalProccess", "withdrawal history id: $withdrawalHistory->id --- customer not found");
                    return;
                }
                unset($withdrawalHistory->customer_id);
                if(! $customerWallet = Wallet::where(['user_id' => $customer->id, "coin_type" => $wallet->coin_type])->first()){
                    createUserWallet($customer->id);
                    if(! $customerWallet = Wallet::where(['user_id' => $customer->id, "coin_type" => $wallet->coin_type])->first()){
                        storeException("walletWithdrawalProccess", "withdrawal history id: $withdrawalHistory->id --- Customer wallet not found!");
                        return;
                    }
                }

                if(! isset($customerWallet->id)){
                    storeException("walletWithdrawalProccess", "withdrawal history id: $withdrawalHistory->id --- Customer id not found in db!");
                    return;
                }



                if(($wallet->decrement("balance", $amount) && $customerWallet->increment("balance", $amount))){
                    $response = $withdrawalHistory->update([
                        "receiver_wallet_id" => $customerWallet->id,
                        "status" => STATUS_ACTIVE
                    ]);storeException("ssssss", json_encode($withdrawalHistory));
                    DepositeTransaction::create($this->createDepositTransaction($withdrawalHistory));
                    DB::commit();
                    storeException("walletWithdrawalProccess", "withdrawal history id: $withdrawalHistory->id --- Customer withdrawal success");
                    return;
                }
                DB::rollBack();
                storeException("walletWithdrawalProccess", "withdrawal history id: $withdrawalHistory->id --- Customer withdrawal failed!");
                return;
            }
            unset($withdrawalHistory->customer_id);

            $withdrawl_type = ADDRESS_TYPE_INTERNAL;
            if(! $addressHistory = WalletAddressHistory::where('address', $withdrawalHistory->address)->first()){
                $withdrawl_type = ADDRESS_TYPE_EXTERNAL;
                if($wallet->decrement("balance", $amount)){
                    $response = $withdrawalHistory->update([ "address_type" => ADDRESS_TYPE_EXTERNAL ]);
                    DB::commit();
                    storeException("walletWithdrawalProccess", "withdrawal history id: $withdrawalHistory->id --- Extarnal withdrawal listed for admin approval!");
                    return;
                }
                DB::rollBack();
                storeException("walletWithdrawalProccess", "withdrawal history id: $withdrawalHistory->id --- Extarnal withdrawal failed!");
                return;
            }

            if($customerWallet = Wallet::find($addressHistory->wallet_id)){
                $wallet->decrement("balance", $amount);
                if($customerWallet->increment("balance", $amount)){
                    $response = $withdrawalHistory->update([
                        "receiver_wallet_id" => $customerWallet->id,
                        "status" => STATUS_ACTIVE
                    ]);
                    DepositeTransaction::create($this->createDepositTransaction($withdrawalHistory));
                    DB::commit();
                    storeException("walletWithdrawalProccess", "withdrawal history id: $withdrawalHistory->id --- Inernal withdrawal success!");
                    return;
                }
                DB::rollBack();
                storeException("walletWithdrawalProccess", "withdrawal history id: $withdrawalHistory->id --- Internal withdrawal failed!");
                return;
            }

            storeException("walletWithdrawalProccess", "withdrawal history id: $withdrawalHistory->id --- Withdrawal failed!");
            return;
        } catch(\Exception $e) {
            storeException("walletWithdrawalProccess", $e->getMessage(). $e->getLine());
            DB::rollBack();
            return;
        }
    }

    private function createDepositTransaction($data)
    {
        return [
            "address" => $data["address"] ?? "",
            "from_address" => NULL,
            "fees" => $data["fees"] ?? "0",
            "sender_wallet_id" => $data["wallet_id"] ?? "",
            "receiver_wallet_id" => $data["receiver_wallet_id"] ?? "",
            "address_type" => $data["address_type"] ?? "",
            "coin_type" => $data["coin_type"] ?? "",
            "amount" => $data["amount"] ?? "",
            "currency_amount" => $data["currency_amount"] ?? "",
            "rate" => $data["rate"] ?? "",
            "currency_type" => $data["currency_type"] ?? "",
            "transaction_id" => $data["transaction_hash"] ?? "",
            "is_admin_receive" => 0,
            "received_amount" => 0,
            "status" => 1,
            "for" => $data["for"] ?? "",
            "network_type" => $data["network_type"] ?? "",
            "confirmations" => 1,
        ];
    }

    private function getCurrencyByCode($code)
    {
        return CurrencyList::where('code', $code)->first();
    }

    private function getCoinByType($type)
    {
        return Coin::where('coin_type', $type)->first();
    }

    public function getExchageRate($request)
    {
        // set false currency values
        $fromCurrencyFound = false;
        $toCurrencyFound   = false;
        $amount = $request->amount ?? 1;

        // check from currency in request
        if($fromCurrency = $this->getCurrencyByCode($request->from)) $fromCurrencyFound = true;
        if($fromCoin = $this->getCoinByType($request->from))  $fromCurrencyFound = true;
        if(!$fromCurrencyFound) return responseData(false, __("Your provided from currency is invalid"));

        // check to currency in request
        if($toCurrency = $this->getCurrencyByCode($request->to))  $toCurrencyFound = true;
        if($toCoin =$this->getCoinByType($request->to)) $toCurrencyFound = true;
        if(!$toCurrencyFound) return responseData(false, __("Your provided to currency is invalid"));

        // convert to currency
        $conver_amount = convert_currency($request->from, $request->to, $amount);

        // return success response
        return responseData(true, __("Rate converted successfully"), [
            "rate" => $conver_amount
        ]);
    }

    private function getUnionWithdrawQuery($user, $request)
    {
        $query = DB::table('withdraw_histories')
        ->select(
            DB::raw(
                'wallets.name, wallets.coin_type, withdraw_histories.amount, withdraw_histories.address_type, 
                withdraw_histories.receiver_wallet_id as sender_wallet, withdraw_histories.transaction_type , 
                withdraw_histories.transaction_hash as trx_id, withdraw_histories.status, withdraw_histories.created_at,
                withdraw_histories.wallet_id, withdraw_histories.for, coins.network_type,
                withdraw_histories.updated_at'
            )
        )
        ->join('wallets', 'withdraw_histories.wallet_id', '=', 'wallets.id')
        ->join('coins', 'wallets.coin_id', '=', 'coins.id')
        ->where('wallets.user_id', $user->id);

        if(isset($request->wallet_id)){
            $query = $query->where('wallets.id', $request->wallet_id);
        }

        if(isset($request->search)){
            $query = $query->where(function($q) use($request) {
                $q->where('withdraw_histories.transaction_hash', 'LIKE', "%$request->search%")
                ->orWhere('withdraw_histories.address', 'LIKE', "%$request->search%")
                ->orWhere('withdraw_histories.created_at', 'LIKE', "%$request->search%");
            });
        }

        if(isset($request->trx_id)){
            $query = $query->where('withdraw_histories.transaction_hash', 'LIKE', "%$request->trx_id%");
        }
        if(isset($request->status)){
            $query = $query->where('withdraw_histories.status', $request->status);
        }

        return $query;
    }

    public function getTransaction($request)
    {
        try {
            $user = Auth::user();
            $transactions = collect();

            $totalPages = 0;
            $totalCount = 0;
            $settingPerPage = settings('pagination_count') ? (int)settings('pagination_count') : 10;
            $page = isset($request->page) ? intval($request->page) : 1;
            $perPage = isset($request->per_page) ? intval($request->per_page) : $settingPerPage;
            $orderBy = isset($request->orderBy) ? $request->orderBy : 'desc';
            $column = isset($request->orderColumn) ? $request->orderColumn : 'created_at';

        
            $transactions = DB::table('deposite_transactions')
                ->select(
                    DB::raw(
                        'wallets.name, wallets.coin_type, deposite_transactions.amount, deposite_transactions.address_type, 
                        deposite_transactions.sender_wallet_id as sender_wallet, deposite_transactions.transaction_type, 
                        deposite_transactions.transaction_id as trx_id, deposite_transactions.status, deposite_transactions.created_at,
                        deposite_transactions.receiver_wallet_id as wallet_id, deposite_transactions.for, coins.network_type,
                        deposite_transactions.updated_at '
                    )
                )
                ->union($this->getUnionWithdrawQuery($user, $request))
                ->join('wallets', 'deposite_transactions.receiver_wallet_id', '=', 'wallets.id')
                ->join('coins', 'wallets.coin_id', '=', 'coins.id')
                ->where('wallets.user_id', $user->id)
                ->orderBy($column, $orderBy);

                if(isset($request->wallet_id)){
                    $transactions = $transactions->where('wallets.id', $request->wallet_id);
                }

                if(isset($request->search)){
                    $transactions = $transactions->where(function($q) use($request) {
                        $q->where('deposite_transactions.transaction_id', 'LIKE', "%$request->search%")
                        ->orWhere('deposite_transactions.address', 'LIKE', "%$request->search%")
                        ->orWhere('deposite_transactions.created_at', 'LIKE', "%$request->search%")
                        ->orWhere('deposite_transactions.from_address', 'LIKE', "%$request->search%");
                    });
                }

                if(isset($request->trx_id)){
                    $transactions = $transactions->where('deposite_transactions.transaction_id', 'LIKE', "%$request->trx_id%");
                }
                
                if(isset($request->status)){
                    $transactions = $transactions->where('deposite_transactions.status', $request->status);
                }

                $totalCount = $transactions->count();
                $totalPages = ceil($totalCount / $perPage);

                if (isset($request->list_size) && $request->list_size === 'all') {
                    $transactions = $transactions->get();
                } else {
                    $transactions = $transactions->skip(($page - 1) * $perPage)
                    ->take($perPage)
                    ->get();
                }
        

            $transactions->map(function($trx) use($request) {
                // set user
                $trx->user = null;
                if($trx->sender_wallet && ($trx->sender_wallet != $trx->wallet_id)){
                    if($wallet = Wallet::with('user:id,name,username,photo')->find($trx->sender_wallet)){
                        $trx->user = $wallet->user ?? null;
                        $trx->user->photo = showUserImage(VIEW_IMAGE_PATH_USER,$trx->user->photo);
                    }
                }

                // set status
                $trx->raw_status = $trx->status;
                $trx->status = deposit_status($trx->status);

                // set transaction type
                $trx->is_deposit = ($trx->transaction_type == TRANSACTION_TYPE_DEPOSIT);
                $trx->is_withdrawal = ($trx->transaction_type == TRANSACTION_TYPE_WITHDRAW);

                // set title
                if($trx->is_withdrawal){
                    $trx->title = __("Internal Withdrawal");
                    if($trx->address_type == ADDRESS_TYPE_EXTERNAL)  $trx->title = __("External Withdrawal");
                }
                if($trx->is_deposit){
                    $trx->title = __("Internal Deposit");
                    if($trx->address_type == ADDRESS_TYPE_EXTERNAL)  $trx->title = __("External Deposit");
                }

                // created_At data
                $trx->created_at = date('Y-m-d\TH:i:s.u\Z', strtotime($trx->created_at));
                // updated data
                $trx->updated_at = date('Y-m-d\TH:i:s.u\Z', strtotime($trx->updated_at));

                // network
                $trx->network = $trx->network_type ? getNetworkType($trx->network_type) : '';
            });

            $data = [
                'total_count' => $totalCount,
                'total_page' => $totalPages,
                'per_page' => $perPage,
                'current_page' => $page,
                'data' => $transactions,
            ];

            if(isset($transactions[0])) return responseData(true, __("Transaction get successfully"), $data);
            return responseData(false, __("Transaction data not found!"), $data);

        } catch (\Exception $e) {
            storeException("getTransaction", $e->getMessage());
            return responseData(false, __("Something went wrong"));
        }
    }


    // Bitgo wallet webhook Start

    public function getBitgoTransaction($coinType, $walletId, $txId)
    {
        try {
            $bitGoService = new BitgoWalletService();
            $bitgoResponse = $bitGoService->transferBitgoData($coinType,$walletId,$txId);
            storeException('getTransaction response ', json_encode($bitgoResponse));
            if ($bitgoResponse['success']) {

                $response = [
                    'success' => true,
                    'message' => __('Data get successfully'),
                    'data' => $bitgoResponse['data']
                ];
            } else {
                storeException('getTransaction', $bitgoResponse['message']);
                $response = [
                    'success' => false,
                    'message' => $bitgoResponse['message'],
                    'data' => []
                ];
            }
        } catch (\Exception $e) {
            storeException('bitgoWalletWebhook getTransaction', $e->getMessage());
            $response = [
                'success' => false,
                'message' => $e->getMessage(),
                'data' => []
            ];
        }
        return $response;
    }
    public function checkAddressAndDeposit($data)
    {
        try {
            storeException('checkAddressAndDeposit', json_encode($data));
            storeException('checkAddressAndDeposit coin_type', $data['coin_type'] ?? "");
            $checkAddress = WalletAddressHistory::where(['address' => $data['address']])->first();
            if ($checkAddress) {
                $wallet = Wallet::find($checkAddress->wallet_id);
                if ($wallet) {
                    storeException('checkAddressAndDeposit wallet ', json_encode($wallet));
                    $deposit = DepositeTransaction::create($this->depositData($data,$wallet));
                    storeException('checkAddressAndDeposit created ', json_encode($deposit));
                    storeException('checkAddressAndDeposit wallet balance before ', $wallet->balance);
                    $wallet->increment('balance',$data['amount']);
                    storeException('checkAddressAndDeposit wallet balance increment ', $wallet->balance);
                    storeException('checkAddressAndDeposit', ' wallet deposit successful');
                    $response = responseData(false,__('Wallet deposited successfully'));
                } else {
                    storeException('checkAddressAndDeposit', ' wallet not found');
                    $response = responseData(false,__('wallet not found'));
                }
            } else {
                storeException('checkAddressAndDeposit', $data['address'].' this address not found in db ');
                $response = responseData(false,__('This address not found in db the address is ').$data['address']);
            }
        } catch (\Exception $e) {
            storeException('checkAddressAndDeposit', $e->getMessage());
            $response = responseData(false,$e->getMessage());
        }
        return $response;
    }

    public function depositData($data,$wallet)
    {
        return [
            'address' => $data['address'],
            'from_address' => isset($data['from_address']) ? $data['from_address'] : "",
            'receiver_wallet_id' => $wallet->id,
            'address_type' => ADDRESS_TYPE_EXTERNAL,
            'coin_type' => $wallet->coin_type,
            'amount' => $data['amount'],
            'transaction_id' => $data['txId'],
            'status' => STATUS_SUCCESS,
            'confirmations' => $data['confirmations']
        ];
    }


    public function bitgoWalletCoinDeposit($coinType, $walletId, $txId)
    {
        try {
            $bitgoService = new BitgoWalletService();
            $checkHash = DepositeTransaction::where(['transaction_id' => $txId])->first();
            if (isset($checkHash)) {
                storeException('bitgoWalletCoinDeposit hash already in db ', $txId);
            } else {
                $getTransaction = $this->getBitgoTransaction($coinType, $walletId, $txId);
                if ($getTransaction['success'] == true) {
                    $transactionData = $getTransaction['data'];
                    if ($transactionData['type'] == 'receive' && $transactionData['state'] == 'confirmed') {
                        $coinVal = $bitgoService->getDepositDivisibilityValues($transactionData['coin']);
                        $amount = bcdiv($transactionData['value'],$coinVal,8);

                        $data = [
                            'coin_type' => $transactionData['coin'],
                            'txId' => $transactionData['txid'],
                            'confirmations' => $transactionData['confirmations'],
                            'amount' => $amount
                        ];

                        if (isset($transactionData['entries'][0])) {
                            foreach ($transactionData['entries'] as $entry) {
                                if (isset($entry['wallet']) && ($entry['wallet'] == $transactionData['wallet'])) {
                                    $data['address'] = $entry['address'];
                                    storeException('entry address', $data['address']);
                                }
                            }
                        }

                        if(isset($data['address'])) {
                            $this->checkAddressAndDeposit($data);
                        }
                    } else {
                        storeException('bitgoWalletCoinDeposit type', 'the transaction type is not receive');
                    }
                } else {
                    storeException('bitgoWalletCoinDeposit failed', $getTransaction['message']);
                }
            }

        } catch (\Exception $e) {
            storeException('bitgoWalletCoinDeposit', $e->getMessage());
        }
    }

    // Bitgo wallet webhook End

    public function sendBitgoCoin($coinType,$walletId,$amount,$address,$walletPassphrase)
    {
        try {
            $bitgoService = new BitgoWalletService();
            $bitgoResponse = $bitgoService->sendCoinsWithBitgo($coinType,$walletId,$amount,$address,$walletPassphrase);
            storeException('send coin api response', json_encode($bitgoResponse));

            if ($bitgoResponse['success'] == true) {
                $response = [
                    'success' => true,
                    'message' => __('Coin send successful'),
                    'data' => $bitgoResponse['data']['txid'],
                ];
            } else {
                storeException('Bitgo sendCoin', $bitgoResponse['message']);
                $response = [
                    'success' => false,
                    'message' => $bitgoResponse['message'],
                    'data' => ""
                ];
            }

        } catch (Exception $e) {
            storeException('sendBitgoCoin', $e->getMessage());
            $response = [
                'success' => false,
                'message' => __('Something went wrong'),
                'data' => ""
            ];
        }
        return $response;
    }

    public function sendCoinWithBitgo($transaction)
    {
        try {
            $coin = Coin::join('coin_settings','coin_settings.coin_id', '=', 'coins.id')
                ->where(['coins.coin_type' => $transaction->coin_type])
                ->select('coins.*', 'coin_settings.*')
                ->first();
            if ($coin) {
                // $currency =  !empty($transaction->network_type) ? $transaction->network_type : $transaction->coin_type;
                $currency = getCoinByNetworkType($coin->network_type) ?? $transaction->coin_type;
                $response = $this->sendBitgoCoin($currency,$coin->bitgo_wallet_id,$transaction->amount,$transaction->address, decrypt($coin->bitgo_wallet));
            } else {
                $response = [
                    'success' => false,
                    'message' => __('Coin not found'),
                    'data' => ''
                ];
            }
        } catch (Exception $e) {
            storeException('sendCoinWithBitgo', $e->getMessage());
            $response = [
                'success' => false,
                'message' => __('Something went wrong'),
                'data' => ''
            ];
        }
        return $response;
    }

    public function withdrawalApproveProccess($id)
    {
        try{
            $adminId = Auth::id();
            if(! $withdrawalHistory = WithdrawHistory::where(['id' => $id, 'status' => STATUS_PENDING])->first())
            return responseData(false, __("Withdrawal request not found"));

            if(isset($withdrawalHistory->address_type) && $withdrawalHistory->address_type == ADDRESS_TYPE_EXTERNAL){
                if(isset($withdrawalHistory->network_type) && $withdrawalHistory->network_type == BITGO_API){
                    $result = $this->sendCoinWithBitgo($withdrawalHistory);
                    if (isset($result['success']) && $result['success']) {
                        $withdrawalHistory->transaction_hash = $result['data'];
                        $withdrawalHistory->status = STATUS_SUCCESS;
                        $withdrawalHistory->updated_by = $adminId;
                        if (empty($adminId)) {
                            $withdrawalHistory->automatic_withdrawal = 'success';
                        }
                        $withdrawalHistory->update();

                        return ['success' => true, 'message' => __('Pending withdrawal accepted Successfully.')];
                    } else {
                        return ['success' => false, 'message' => $result['message']];
                    }
                }
            }
            return responseData(true, __("Withdrawal request do not complete"));
        } catch (Exception $e){
            storeException("withdrawalRejecteProccess", $e->getMessage());
            return responseData(false, __("Something went wrong!"));
        }
    }

    public function withdrawalRejecteProccess($id)
    {
        try{
            if(! $withdrawalHistory = WithdrawHistory::where(['id' => $id, 'status' => STATUS_PENDING])->first())
            return responseData(false, __("Withdrawal request not found"));

            $fees = 0;
            if(isset($withdrawalHistory->fees) && is_numeric($withdrawalHistory->fees) && $withdrawalHistory->fees > 0){
                $fees = $withdrawalHistory->fees;
            }
            $amount = $withdrawalHistory->amount + $fees;
            if(! $wallet = Wallet::find($withdrawalHistory->wallet_id))
                return responseData(false, __("User wallet not found"));

            if(!$wallet->increment("balance", $amount))
                return responseData(false, __("Failed to refund user wallet"));

            $withdrawalHistory->status = STATUS_REJECTED;
            $withdrawalHistory->updated_by = Auth::id();
            if($withdrawalHistory->update())
            return responseData(true, __("Withdrawal request rejected successfully"));
            return responseData(false, __("Withdrawal request failed to reject"));
        } catch (Exception $e){
            storeException("withdrawalRejecteProccess", $e->getMessage());
            return responseData(false, __("Something went wrong!"));
        }
    }
}
