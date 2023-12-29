<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Models\WithdrawHistory;
use App\Models\DepositeTransaction;
use App\Http\Controllers\Controller;

class TransactionController extends Controller
{

    public function adminPendingWithdrawal(Request $request)
    {
        $data['title'] = __('Pending Withdrawal');
        if ($request->ajax()) {
            $withdrawal = WithdrawHistory::select(
                'withdraw_histories.id',
                'withdraw_histories.address'
                , 'withdraw_histories.amount'
                , 'withdraw_histories.user_id'
                , 'withdraw_histories.fees'
                , 'withdraw_histories.transaction_hash'
                , 'withdraw_histories.confirmations'
                , 'withdraw_histories.address_type as addr_type'
                , 'withdraw_histories.updated_at'
                , 'withdraw_histories.wallet_id'
                , 'withdraw_histories.coin_type'
                , 'withdraw_histories.network_type'
                , 'withdraw_histories.receiver_wallet_id'
                , 'withdraw_histories.memo'
            )->where(['withdraw_histories.status' => STATUS_PENDING])
                ->orderBy('withdraw_histories.id', 'desc');

            return datatables()->of($withdrawal)
                ->addColumn('address_type', function ($wdrl) {
                    return addressType($wdrl->addr_type);
                })
                ->addColumn('coin_type', function ($wdrl) {
                    return find_coin_type($wdrl->coin_type);
                })
                ->addColumn('sender', function ($wdrl) {
                    if(!empty($wdrl->user)) $user = $wdrl->user;
                    else $user = isset($wdrl->senderWallet) ? $wdrl->senderWallet->user : null;
                    return isset($user) ? $user->name : 'N/A';
                })
                ->addColumn('receiver', function ($wdrl) {
                    if (!empty($wdrl->receiverWallet) && $wdrl->receiverWallet->type == CO_WALLET) return  'Multi-signature Pocket: '.$wdrl->receiverWallet->name;
                    else
                    return isset($wdrl->receiverWallet->user) ? $wdrl->receiverWallet->user->name : 'N/A';
                })
                ->addColumn('network', function ($wdrl) {
                    return api_settings($wdrl->network_type);
                })
                ->addColumn('actions', function ($wdrl) {
                    $action = '<div class="activity-icon"><ul>';
                    // $action .= accept_html('adminAcceptPendingWithdrawal',encrypt($wdrl->id));
                    // $action .= reject_html('adminRejectPendingWithdrawal',encrypt($wdrl->id));
                    $action .= '</ul> </div>';

                    return $action;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('withdrawal.pending_list', $data);
    }

    public function adminActiveWithdrawal(Request $request)
    {
        $data['title'] = __('Completed Withdrawal');
        if ($request->ajax()) {
            $withdrawal = WithdrawHistory::select(
                'withdraw_histories.address'
                , 'withdraw_histories.amount'
                , 'withdraw_histories.user_id'
                , 'withdraw_histories.fees'
                , 'withdraw_histories.transaction_hash'
                , 'withdraw_histories.confirmations'
                , 'withdraw_histories.address_type as addr_type'
                , 'withdraw_histories.updated_at'
                , 'withdraw_histories.wallet_id'
                , 'withdraw_histories.coin_type'
                , 'withdraw_histories.network_type'
                , 'withdraw_histories.receiver_wallet_id'
                , 'withdraw_histories.memo'
            )->where(['withdraw_histories.status' => STATUS_SUCCESS])
                ->orderBy('withdraw_histories.id', 'desc');

            return datatables()->of($withdrawal)
                ->addColumn('address_type', function ($wdrl) {
                    return addressType($wdrl->addr_type);
                })
                ->addColumn('coin_type', function ($wdrl) {
                    return find_coin_type($wdrl->coin_type);
                })
                ->addColumn('sender', function ($wdrl) {
                    if(!empty($wdrl->user)) $user = $wdrl->user;
                    else $user = isset($wdrl->senderWallet) ? $wdrl->senderWallet->user : null;
                    return isset($user) ? $user->name : 'N/A';
                })
                ->addColumn('network', function ($wdrl) {
                    return api_settings($wdrl->network_type);
                })
                ->addColumn('receiver', function ($wdrl) {
                    if (!empty($wdrl->receiverWallet) && $wdrl->receiverWallet->type == CO_WALLET) return  'Multi-signature Pocket: '.$wdrl->receiverWallet->name;
                    else
                    return isset($wdrl->receiverWallet->user) ? $wdrl->receiverWallet->user->name : 'N/A';
                })
                ->make(true);
        }

        return view('withdrawal.active_list', $data);
    }

    public function adminRejectedWithdrawal(Request $request)
    {
        $data['title'] = __('Rejected Withdrawal');
        if ($request->ajax()) {
            $withdrawal = WithdrawHistory::select(
                'withdraw_histories.address'
                , 'withdraw_histories.amount'
                , 'withdraw_histories.user_id'
                , 'withdraw_histories.fees'
                , 'withdraw_histories.transaction_hash'
                , 'withdraw_histories.confirmations'
                , 'withdraw_histories.address_type as addr_type'
                , 'withdraw_histories.updated_at'
                , 'withdraw_histories.wallet_id'
                , 'withdraw_histories.coin_type'
                , 'withdraw_histories.network_type'
                , 'withdraw_histories.receiver_wallet_id'
                , 'withdraw_histories.memo'
            )->where(['withdraw_histories.status' => STATUS_REJECTED])
                ->orderBy('withdraw_histories.id', 'desc');

            return datatables()->of($withdrawal)
                ->addColumn('address_type', function ($wdrl) {
                    return addressType($wdrl->addr_type);
                })
                ->addColumn('coin_type', function ($wdrl) {
                    return find_coin_type($wdrl->coin_type);
                })
                ->addColumn('sender', function ($wdrl) {
                    if(!empty($wdrl->user)) $user = $wdrl->user;
                    else $user = isset($wdrl->senderWallet) ? $wdrl->senderWallet->user : null;
                    return isset($user) ? $user->name : 'N/A';
                })
                ->addColumn('network', function ($wdrl) {
                    return api_settings($wdrl->network_type);
                })
                ->addColumn('receiver', function ($wdrl) {
                    if (!empty($wdrl->receiverWallet) && $wdrl->receiverWallet->type == CO_WALLET) return  'Multi-signature Pocket: '.$wdrl->receiverWallet->name;
                    else
                    return isset($wdrl->receiverWallet->user) ? $wdrl->receiverWallet->user->name : 'N/A';
                })
                ->make(true);
        }

        return view('withdrawal.reject_list', $data);
    }

    public function adminPendingDeposit(Request $request)
    {
        $data['title'] = __('Pending Deposit');
        if ($request->ajax()) {
            $items = DepositeTransaction::where(['status' => STATUS_PENDING, 'address_type' => ADDRESS_TYPE_EXTERNAL])
                ->orderBy('id', 'desc');

            return datatables()->of($items)
                ->addColumn('created_at', function ($item) {
                    return $item->created_at;
                })
                ->addColumn('receiver_wallet_id', function ($item) {
                    return isset($item->receiverWallet->user->email) ? $item->receiverWallet->user->email : 'N/A';
                })
                ->addColumn('actions', function ($item) {
                    $action = '<div class="activity-icon"><ul>';
                    
                    $action .= '</ul> </div>';

                    return $action;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('deposit.pending_deposit', $data);
    }

    public function adminActiveDeposit(Request $request)
    {
        $data['title'] = __('Transaction History');
        if ($request->ajax()) {
            $deposit = DepositeTransaction::select('deposite_transactions.address'
                , 'deposite_transactions.amount'
                , 'deposite_transactions.fees'
                , 'deposite_transactions.transaction_id'
                , 'deposite_transactions.confirmations'
                , 'deposite_transactions.address_type as addr_type'
                , 'deposite_transactions.created_at'
                , 'deposite_transactions.sender_wallet_id'
                , 'deposite_transactions.receiver_wallet_id'
                , 'deposite_transactions.status'
                , 'deposite_transactions.coin_type'
                , 'deposite_transactions.network_type'
            )->orderBy('deposite_transactions.id', 'desc');

            return datatables()->of($deposit)
                ->addColumn('address_type', function ($dpst) {
                    if ($dpst->addr_type == 'internal_address') {
                        return __('External');
                    } else {
                        return addressType($dpst->addr_type);
                    }

                })
                ->addColumn('coin_type', function ($dpst) {
                    return $dpst->coin_type;
                })
                ->addColumn('status', function ($dpst) {
                    return deposit_status($dpst->status);
                })
                ->addColumn('sender', function ($dpst) {
                    if (!empty($dpst->senderWallet) && $dpst->senderWallet->type == CO_WALLET) return  'Multi-signature Pocket: '.$dpst->senderWallet->name;
                    else
                        return isset($dpst->senderWallet->user) ? $dpst->senderWallet->user->first_name . ' ' . $dpst->senderWallet->user->last_name : 'N/A';
                })
                ->addColumn('receiver', function ($dpst) {
                    if (!empty($dpst->receiverWallet) && $dpst->receiverWallet->type == CO_WALLET) return  'Multi-signature Pocket: '.$dpst->receiverWallet->name;
                    else
                        return isset($dpst->receiverWallet->user) ? $dpst->receiverWallet->user->first_name . ' ' . $dpst->receiverWallet->user->last_name : 'N/A';
                })
                ->make(true);
        }
        return view('deposit.active_deposit', $data);        
    }
}
