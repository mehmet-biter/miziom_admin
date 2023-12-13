<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        "btc",
        "doller",
        "transaction_id",
        "is_admin_receive",
        "received_amount",
        "status",
        "updated_by",
        "network_type",
        "confirmations",
    ];
}
