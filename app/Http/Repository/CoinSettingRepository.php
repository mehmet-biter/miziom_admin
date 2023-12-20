<?php

namespace App\Http\Repository;

use App\Models\CoinSetting;

class CoinSettingRepository extends BaseRepository
{
    public $model;
    function __construct()
    {
        $this->model = new CoinSetting();
        parent::__construct($this->model);
    }

    public function getCoinSettingData($coinId)
    {
        $coinSetting = $this->createCoinSetting($coinId);
        return CoinSetting::join('coins', 'coins.id', '=','coin_settings.coin_id')->select('coins.*', 'coin_settings.*','coin_settings.id as coin_setting_id')
            ->where(['coin_settings.coin_id' => $coinSetting->coin_id])
            ->first();
    }

    public function createCoinSetting($coinId)
    {
        return CoinSetting::firstOrCreate(['coin_id' => $coinId], []);
    }

}
