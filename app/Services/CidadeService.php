<?php
/**
 * Created by PhpStorm.
 * User: hugomachado
 * Date: 29/08/15
 * Time: 23:43
 */

namespace App\Services;

use App\Service;
use App\Contracts\CidadeRepositoryInterface;


class CidadeService extends Service
{
    public function __construct(CidadeRepositoryInterface $cidadeRepositoryInterface)
    {
        $this->repository = $cidadeRepositoryInterface;
    }

    public function listCidadesByUf($uf)
    {

        return $this->repository->listCidadesByUf($uf);
    }

    public function listarCidadesApi($uf)
    {
    	$rows =  $this->repository->listCidadesByUf($uf);
        foreach($rows as $row)
        {
        	$nome = strtolower($row->nome);
        	$nome = ucwords($nome);
            $data[]=[
                'id' => $row->id,
                'nome' => $nome
            ];
        }

        return $data;  
    }

} 