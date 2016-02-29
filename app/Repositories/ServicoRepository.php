<?php

namespace App\Repositories;


use App\Contracts\ServicoRepositoryInterface;
use App\Repository;
use App\Servico;


class ServicoRepository extends Repository implements ServicoRepositoryInterface
{

    public function __construct(Servico $servico)
    {
        $this->model = $servico;
    }

    public function byUser($id)
    {
        return $this->model->where('user_id',$id)->get();
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