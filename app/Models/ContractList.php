<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractList extends Model
{
    use HasFactory;
    protected $fillable = [
        'unique_code',
        'name',
        'email',
        'mobile',
        'subject',
        'description',
        'status'
    ];
}
