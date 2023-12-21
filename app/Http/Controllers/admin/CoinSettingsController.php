<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CoinSettingsController extends Controller
{
    private $coinService;
    private $coinSettingService;
    private $logger;
    public function __construct()
    {
        // $this->coinService = new CoinService();
        // $this->logger = new Logger();
        // $this->coinSettingService = new CoinSettingService();
    }
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
