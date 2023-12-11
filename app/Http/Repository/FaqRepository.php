<?php
namespace App\Http\Repository;

use App\Http\Repository\BaseRepository;
use App\Models\Faq;

class FaqRepository extends BaseRepository
{
    public $model;

    function __construct()
    {
        $this->model = new Faq();
        parent::__construct($this->model);
    }

    public function list($module)
    {
        return $this->model->where('status',$module);
    }
}
