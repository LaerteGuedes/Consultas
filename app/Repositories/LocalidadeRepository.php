<?php
/**
 * Created by PhpStorm.
 * User: hugomachado
 * Date: 29/08/15
 * Time: 22:59
 */

namespace App\Repositories;

use App\Contracts\LocalidadeRepositoryInterface;
use App\Repository;
use App\Localidade;


class LocalidadeRepository extends Repository implements LocalidadeRepositoryInterface
{
    public function __construct(Localidade $localidade)
    {
        $this->model = $localidade;
    }

    public function getTipos()
    {
        return $this->model->getTipos();
    }

    public function paginateByUser($id)
    {
        return $this->model->where('user_id',$id)->paginate();
    }

    public function listForComboByUser($id)
    {
        $data = [];
        $locais = $this->model->where('user_id',$id)->get();

        if($locais)
        {
            foreach($locais as $local)
            {
                $data[] = [

                    'id' => $local->id,
                    'local' => sprintf("%s - %s %s, %s, %s - %s" , $this->model->getTipos()[$local->tipo] ,$local->logradouro,$local->numero,$local->bairro->nome,$local->cidade->nome,$local->uf)
                ];
            }
        }

        return $data;
    }
} 