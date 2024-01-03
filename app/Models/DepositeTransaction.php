<?php

namespace App\Models;

use App\Models\Wallet;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DepositeTransaction extends Model
{
    use HasFactory;
    protected $fillable = [
        "id",
        "address",
        "from_address",
        "fees",
        "sender_wallet_id",
        "receiver_wallet_id",
        "address_type",
        "coin_type",
        "amount",
        "currency_amount",
        "rate",
        "currency_type",
        "transaction_id",
        "is_admin_receive",
        "received_amount",
        "status",
        "updated_by",
        "network_type",
        "confirmations",
    ];

    public function senderWallet(){
        return $this->belongsTo(Wallet::class,'sender_wallet_id','id');
    }
    public function receiverWallet(){
        return $this->belongsTo(Wallet::class,'receiver_wallet_id','id');
    }
}
