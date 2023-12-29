<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Models\WithdrawHistory;
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
                    return isset($user) ? $user->first_name . ' ' . $user->last_name : 'N/A';
                })
                ->addColumn('receiver', function ($wdrl) {
                    if (!empty($wdrl->receiverWallet) && $wdrl->receiverWallet->type == CO_WALLET) return  'Multi-signature Pocket: '.$wdrl->receiverWallet->name;
                    else
                    return isset($wdrl->receiverWallet->user) ? $wdrl->receiverWallet->user->first_name . ' ' . $wdrl->receiverWallet->user->last_name : 'N/A';
                })
                ->addColumn('actions', function ($wdrl) {
                    $action = '<div class="activity-icon"><ul>';
                    $action .= accept_html('adminAcceptPendingWithdrawal',encrypt($wdrl->id));
                    $action .= reject_html('adminRejectPendingWithdrawal',encrypt($wdrl->id));
                    $action .= '</ul> </div>';

                    return $action;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('withdrawal.list', $data);
    }
}
