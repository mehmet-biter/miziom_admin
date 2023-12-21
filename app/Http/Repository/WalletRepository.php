<?php
namespace App\Http\Repository;

use App\Http\Repository\BaseRepository;
use App\Models\Wallet;

class WalletRepository extends BaseRepository
{
    public $model;

    function __construct()
    {
        $this->model = new Wallet();
        parent::__construct($this->model);
    }

    public function getUserWalletList($userId,$type,$currency){
        $list = [];
        try {
            $query = Wallet::join('coins', 'coins.id', '=','wallets.coin_id')
                ->where(['wallets.user_id' => $userId,'wallets.status' => STATUS_ACTIVE, 'coins.status' => STATUS_ACTIVE]);
            if ($type == CURRENCY_TYPE_BOTH) {
                $query->whereIn('coins.currency_type',[CURRENCY_TYPE_FIAT,CURRENCY_TYPE_CRYPTO]);
            } else {
                $query->where(['coins.currency_type' => (int)$type]);
            }
            $list = $query->get();

        } catch(\Exception $e) {
            storeException('getUserWalletList',$e->getMessage());
        }
        return $list;
    }
}
