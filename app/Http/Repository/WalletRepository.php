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
}
