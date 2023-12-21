<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coin extends Model
{
    use HasFactory;
    protected $fillable = [
        "name",
        "coin_type",
        "currency_type",
        "currency_id",
        "coin_price",
        "status",
        "network",

        "is_withdrawal",
        "minimum_withdrawal",
        "maximum_withdrawal",
        "max_send_limit",
        "withdrawal_fees",
        "withdrawal_fees_type",

        "is_deposit",
        "coin_icon",
        
        "is_convert",
        "minimum_convert",
        "maximum_convert",
        "max_send_limit",
        "convert_fees",
        "convert_fees_type",
    ];
}
