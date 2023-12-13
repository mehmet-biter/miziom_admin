<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        "id",
        "wallet_id",
        "address",
        "coin_type",
        "BTC",
        "wallet_key",
        "public_key",
    ];
}
