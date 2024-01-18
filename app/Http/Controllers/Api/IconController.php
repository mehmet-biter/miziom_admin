<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\IconCategory;
use Illuminate\Http\Request;

class IconController extends Controller
{
    public function getIcons()
    {
        $icons = IconCategory::with(['icons' => function($q){
            return $q->where('status', STATUS_ACTIVE);
        }])->where('status', STATUS_ACTIVE)->get();

        if(isset($icons[0])){
            $icons->map(function($icon){
                if(isset($icon->icons[0])){
                    $iconData = $icon->icons;
                    $iconData->map(function($i){
                        $i->icon = (isset($i->icon) && !empty($i->icon)) ?
                                    asset(IMG_PATH . $i->icon): null;
                    });
                }
            });
            return response()->json(responseData(true, __("Icon list get successfully"), $icons));
        }
        return response()->json(responseData(false, __("Icon list not found!")));
    }
}
