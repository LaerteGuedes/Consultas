<?php
/**
 * Created by PhpStorm.
 * User: hugomachado
 * Date: 29/08/15
 * Time: 23:01
 */

namespace App\Services;

use App\Service;
use App\Contracts\LocalidadeRepositoryInterface;


class LocalidadeService extends Service
{
    public function __construct(LocalidadeRepositoryInterface $localidadeRepositoryInterface)
    {
        $this->repository = $localidadeRepositoryInterface;
    }

    public function getTipos()
    {
        return $this->repository->getTipos();
    }
    public function paginateByUser($id)
    {
        return $this->repository->paginateByUser($id);
    }
    public function listForComboByUser($id)
    {
        return $this->repository->listForComboByUser($id);
    }

    public function getComplete($id)
    {
        return $this->repository->getComplete($id);
    }

    public function create(array $data)
    {
        if(isset($data['preco']) && $data['preco'] !== '0,00')
        {
            $data['preco'] = str_replace('.','',$data['preco']);
            $data['preco'] = str_replace(',','.',$data['preco']);
        }

        return $this->repository->create($data);
    }
    public function update($id , array $data)
    {
        if(isset($data['preco']) && $data['preco'] != '0,00')
        {
            $data['preco'] = str_replace('.','',$data['preco']);
            $data['preco'] = str_replace(',','.',$data['preco']);
        }

        return $this->repository->update($id, $data);
    }    
} 