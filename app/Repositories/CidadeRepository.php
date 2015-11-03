<?php
/**
 * Created by PhpStorm.
 * User: hugomachado
 * Date: 29/08/15
 * Time: 23:40
 */

namespace App\Repositories;

use App\Contracts\CidadeRepositoryInterface;
use App\Repository;
use App\Cidade;


class CidadeRepository extends Repository implements CidadeRepositoryInterface
{
    public function __construct(Cidade $cidade)
    {
        $this->model = $cidade;

    }

    public function listCidadesByUf($uf)
    {
        return $this->model->where('uf','=',$uf)->orderBy('nome','asc')->get(['id','nome']);
    }
} 