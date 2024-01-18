<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IconList extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'tag',
        'status',
        'icon',
    ];
}
