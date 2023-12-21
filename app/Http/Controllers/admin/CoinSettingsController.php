<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CoinSettingsController extends Controller
{
    public function adminCoinApiSettings(Request $request)
    {
        $data['tab']='payment';
        if(isset($_GET['tab'])){
            $data['tab']=$_GET['tab'];
        }
        $data['title'] = __('Coin Api Settings');
        $data['settings'] = allsetting();

        return view('admin.settings.api.general', $data);
    }
}
