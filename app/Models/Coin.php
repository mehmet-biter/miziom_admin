<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coin extends Model
{
    use HasFactory;
    protected $fillable = [
        "id",
        "name",
        "coin_type",
        "currency_type",
        "currency_id",
        "coin_price",
        "usd_rate",
        "status",
        "network",
        "is_withdrawal",
        "is_deposit",
        "coin_icon",
        "is_wallet",
        "is_transferable",
        "network",
        "is_virtual_amount",
        "sign",
        "minimum_buy_amount",
        "maximum_buy_amount",
        "minimum_sell_amount",
        "maximum_sell_amount",
        "minimum_withdrawal",
        "maximum_withdrawal",
        "max_send_limit",
        "withdrawal_fees",
        "withdrawal_fees_type",
    ];
}
