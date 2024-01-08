<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\DepositeTransaction;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Services\WalletService;

class WalletNotifier extends Controller
{
    private $service;
    public function __construct()
    {
        $this->service = new WalletService();
    }
    
    public function bitgoWalletWebhook(Request $request)
    {
        Log::info('bitgoWalletWebhook start');
        try {
            storeException('bitgoWalletWebhook',' bitgoWalletWebhook called');
            storeException('bitgoWalletWebhook $request',json_encode($request->all()));

            if (isset($request->hash)) {
                $txId = $request->hash;
                $type = $request->type;
                $coinType = $request->coin;
//                $state = $request->state;
                $walletId = $request->wallet;
                storeException('bitgoWalletWebhook hash', $txId);
                if ($type == 'transfer' || $type == 'transaction') {
                    $checkHashInDB = DepositeTransaction::where(['transaction_id' => $txId])->first();
                    if (isset($checkHashInDB)) {
                        storeException('bitgoWalletWebhook, already deposited hash -> ',$txId);
                    } else {
                        storeException('bitgoWalletCoinDeposit', 'called -> ');
                        $this->service->bitgoWalletCoinDeposit($coinType,$walletId,$txId);
                    }
                }
            }
        } catch (\Exception $e) {
            storeException('bitgoWalletWebhook', $e->getMessage());
        }

    }
}
