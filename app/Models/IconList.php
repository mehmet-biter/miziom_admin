<?php

namespace App\Models;

use App\Models\IconCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IconList extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'tag',
        'category_id',
        'status',
        'icon',
    ];

    public function category()
    {
        return $this->belongsTo(IconCategory::class, 'category_id');
    }

}
