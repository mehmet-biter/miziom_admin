<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;
    protected $fillable = [
        "id",
        "user_id",
        "user_id",
        "name",
        "coin_id",
        "key",
        "type",
        "coin_type",
        "status",
        "is_primary",
        "balance",
        "referral_balance",
    ];

    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }

    public function coin()
    {
        return $this->belongsTo(Coin::class,'coin_id');
    }
}
