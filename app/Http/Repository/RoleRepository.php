<?php
namespace App\Http\Repository;

use App\Http\Repository\BaseRepository;
use App\Models\Role;

class RoleRepository extends BaseRepository
{
    public $model;

    function __construct()
    {
        $this->model = new Role();
        parent::__construct($this->model);
    }

}
