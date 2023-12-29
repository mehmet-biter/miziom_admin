<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        "user_id",
        "wallet_id",
        "amount",
        "btc",
        "doller",
        "address_type",
        "address",
        "transaction_hash",
        "coin_type",
        "used_gas",
        "receiver_wallet_id",
        "confirmations",
        "fees",
        "status",
        "updated_by",
        "automatic_withdrawal",
        "network_type",
        "memo",
        "message",
    ];
}
