<?php

namespace App\Http\Controllers\admin;

use App\Models\Coin;
use App\Models\DepositeTransaction;
use App\Models\User;
use App\Models\WithdrawHistory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $default_coin = settings('default_coin') ?? 'USDC';

        $data['title'] = __("Dashboard");
        $data['users'] = User::get()->count();
        $data['coins'] = Coin::get()->count();

        $profit = WithdrawHistory::where('status', STATUS_ACTIVE)->get();
        $total_profit = 0;
        if(isset($profit[0])){
            foreach ($profit as $p) {
                $coin = $p->coin_type;
                $total_profit += convert_currency($coin, $default_coin, ($p->fees ?? 0));
            }
        }
        $data['profit'] = $total_profit;

        $deposit = DepositeTransaction::get();
        $total_deposit = 0;
        if(isset($deposit[0])){
            foreach ($deposit as $de) {
                $coin = $de->coin_type;
                $total_deposit += convert_currency($coin, $default_coin, ($de->amount ?? 0));
            }
        }
        $data['deposit'] = $total_deposit;
        $data['recent_deposit'] = DepositeTransaction::where('status', STATUS_ACTIVE)->latest()->take(6)->get();
        $data['recent_withdrawal'] = WithdrawHistory::where('status', STATUS_ACTIVE)->latest()->take(6)->get();

        return view('index', $data);
    }
}
