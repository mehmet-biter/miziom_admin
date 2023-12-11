<?php
namespace App\Http\Repository;

use App\Http\Repository\BaseRepository;
use App\Models\ContractList;

class ContactRepository extends BaseRepository
{
    public $model;

    function __construct()
    {
        $this->model = new ContractList();
        parent::__construct($this->model);
    }


}
