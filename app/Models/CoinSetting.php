<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoinSetting extends Model
{
    use HasFactory;
    protected $fillable = [
        "coin_id",
        "bitgo_wallet_id",
        "bitgo_deleted_status",
        "bitgo_approvalsRequired",
        "bitgo_wallet_type",
        "bitgo_wallet",
        "chain",
        "webhook_status",
        "coin_api_user",
        "coin_api_pass",
        "coin_api_host",
        "coin_api_port",
        "check_encrypt",
        "bitgo_webhook_label",
        "bitgo_webhook_type",
        "bitgo_webhook_url",
        "bitgo_webhook_numConfirmations",
        "bitgo_webhook_allToken",
        "bitgo_webhook_id",
    ];
}
