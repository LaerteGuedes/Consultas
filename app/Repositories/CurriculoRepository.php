<?php

namespace App\Repositories;

use App\Contracts\CurriculoRepositoryInterface;
use App\Repository;
use App\Curriculo;


class CurriculoRepository extends Repository implements CurriculoRepositoryInterface
{
    public function __construct(Curriculo $curriculo)
    {
        $this->model = $curriculo;
    }

    public function paginateByUser($id)
    {
        return $this->model->where('user_id',$id)->paginate();
    }
    public function checkUserHasItem($user_id,$id)
    {
        return $this->model->where('user_id',$user_id)
                           ->where('id',$id)
                           ->first();

    }
} 