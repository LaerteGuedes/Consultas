<?php
/**
 * Created by PhpStorm.
 * User: hugomachado
 * Date: 29/08/15
 * Time: 23:45
 */

namespace App\Repositories;

use App\Repository;
use App\Contracts\BairroRepositoryInterface;
use App\Bairro;


class BairroRepository extends Repository implements BairroRepositoryInterface
{
    public function __construct(Bairro $bairro)
    {
        $this->model = $bairro;
    }

    public function listBairroByCidade($id)
    {
        return $this->model->where('cidade_id',$id)->whereNotNull('nome')->groupBy('nome')->where('nome', 'not like', '%,%')->orderBy('nome','asc')->get(['id','nome']);
    }

    public function listBairroByCidadeOnlyUnique($id)
    {
        return $this->model->where('cidade_id',$id)->where('nome', 'not like', '%,%')->orderBy('nome','asc')->get(['id','nome']);
    }
} 