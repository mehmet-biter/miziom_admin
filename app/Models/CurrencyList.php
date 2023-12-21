<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrencyList extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'code',
        'symbol',
        'usd_rate',
        'status',
        'is_primary',
    ];
}
