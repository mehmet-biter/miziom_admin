<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletAddressHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        "id",
        "wallet_id",
        "address",
        "coin_type",
        "wallet_key",
        "public_key",
    ];
}
