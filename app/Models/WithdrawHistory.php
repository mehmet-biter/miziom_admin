<?php

namespace App\Models;

use App\Models\Coin;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WithdrawHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        "user_id",
        "wallet_id",
        "amount",
        "currency_amount",
        "rate",
        "currency_type",
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
        "for",
        "message",
    ];

    public function senderWallet(){
        return $this->belongsTo(Wallet::class,'wallet_id','id');
    }
    public function coin()
    {
        return $this->belongsTo(Coin::class, 'coin_type', 'coin_type');
    }
    public function receiverWallet(){
        return $this->belongsTo(Wallet::class,'receiver_wallet_id','id');
    }
    public function wallet()
    {
        return $this->belongsTo(Wallet::class,'wallet_id');
    }
    public function users(){
        return $this->belongsTo(User::class,'wallet_id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
