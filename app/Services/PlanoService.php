<?php
/**
 * Created by PhpStorm.
 * User: laerteguedes
 * Date: 07/11/15
 * Time: 08:54
 */

namespace App\Services;


use App\Repositories\PlanoRepository;
use App\Repositories\repository;
use App\Service;

class PlanoService extends Service
{
    public function __construct(PlanoRepository $repository)
    {
        $this->repository = $repository;
    }

    public function paginateByUser($id)
    {
        return $this->repository->paginateByUser($id);
    }

    public function findParents(){
        return $this->repository->findParents();
    }

    public function findChildren($id){
        return $this->repository->findChildren($id);
    }

    public function findParentsById($id)
    {
        return $this->repository->findParentsById($id);
    }

    public function findAllChildrenCheckbox()
    {
        $planos = $this->repository->findAllChildren();
        $vPlano = array();
        foreach ($planos as $plano){
            $vPlano[$plano->id] = ['checked' => 'false', 'titulo' => $plano->titulo];
        }

        return $vPlano;
    }

    public function insertUserPlanos($id, $planos)
    {
        return $this->repository->insertUserPlanos($id, $planos);
    }
}