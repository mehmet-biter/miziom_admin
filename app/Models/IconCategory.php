<?php

namespace App\Models;

use App\Models\IconList;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IconCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'status'
    ];

    public function icons()
    {
        return $this->hasMany(IconList::class, "category_id", "id");
    }
}
