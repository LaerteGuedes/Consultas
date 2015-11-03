<?php
/**
 * Created by PhpStorm.
 * User: hugomachado
 * Date: 29/08/15
 * Time: 23:08
 */

namespace App\Services;

use App\Service;
use App\Contracts\EstadoRepositoryInterface;

class EstadoService extends Service
{

    public function __construct(EstadoRepositoryInterface $estadoRepositoryInterface)
    {
        $this->repository = $estadoRepositoryInterface;
    }

    public function listCombo()
    {
       $data =  $this->repository->listCombo();

       foreach($data as $uf => $nome )
       {
           $combo[$uf] = $nome;
       }
        return $combo;
    }
    public function listarEstadosApi()
    {
        $rows = $this->repository->listarEstadosApi();

        foreach($rows as $row)
        {
            $data[]=[
                'uf' => $row->uf,
                'nome' => ucwords($row->nome)
            ];
        }

        return $data;  
    }
} 