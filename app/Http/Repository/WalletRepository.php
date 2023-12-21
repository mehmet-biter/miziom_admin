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
        try {
            $query = Wallet::query()->where(['user_id' => $userId,'status' => STATUS_ACTIVE]);

        } catch(\Exception $e) {
            storeException('getUserWalletList',$e->getMessage());
        }
    }
}
