<?php

namespace App\Http\Services;

use DateTime;
use App\Models\Coin;
use App\Models\User;
use App\Models\Wallet;
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
                    ->get(['id', 'username', 'unique_code', 'name', 'email']);
            $data['customer'] = $user;

            if(isset($user[0])) return responseData(true, __('Customer get successfully'),$data);
            return responseData(false, __('Customer not found!')); 
        } catch(\Exception $e) {
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
                    $address = $bitgoApi->createBitgoWalletAddress($coin->coin_type,$coin->bitgo_wallet_id,$coin->chain);
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
        return [
            "user_id"              => $user->id,
            "wallet_id"            => $wallet->id,
            "amount"               => $amount,
            "currency_amount"      => $currencyAmount,
            "rate"                 => $rate,
            "address_type"         => ADDRESS_TYPE_INTERNAL,
            "address"              => $request->address ?? '',
            "transaction_hash"     => Str::random(32),
            "coin_type"            => $wallet->coin_type,
            "currency_type"        => $defaultCurrency,
            // "used_gas"             => 0,
            "confirmations"        => 1,
            "fees"                 => $fees,
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
                    storeException("walletWithdrawalProccess", "withdrawal history id: $withdrawalHistory->id --- Extarnal withdrawal success!");
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
                withdraw_histories.wallet_id'
            )
        )
        ->join('wallets', 'withdraw_histories.wallet_id', '=', 'wallets.id')
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
                        deposite_transactions.receiver_wallet_id as wallet_id'
                    )
                )
                ->union($this->getUnionWithdrawQuery($user, $request))
                ->join('wallets', 'deposite_transactions.receiver_wallet_id', '=', 'wallets.id')
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
                    if($wallet = Wallet::with('user:id,name,username')->find($trx->sender_wallet))
                        $trx->user = $wallet->user ?? null;
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
}
