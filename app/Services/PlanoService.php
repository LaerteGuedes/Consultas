<?php
/**
 * Created by PhpStorm.
 * User: laerteguedes
 * Date: 07/11/15
 * Time: 08:54
 */

namespace App\Services;


use App\Repositories\PlanoRepository;

class PlanoService
{
    protected $planoRepository;

    public function __construct(PlanoRepository $planoRepository)
    {
        $this->planoRepository = $planoRepository;
    }

    public function paginateByUser($id)
    {
        return $this->planoRepository->paginateByUser($id);
    }

    public function all(){
        return $this->planoRepository->all();
    }

    public function find($id)
    {
        return $this->planoRepository->find($id);
    }

    public function findParents(){
        return $this->planoRepository->findParents();
    }

    public function findChildren($id){
        return $this->planoRepository->findChildren($id);
    }

    public function findParentsById($id)
    {
        return $this->planoRepository->findParentsById($id);
    }

    public function findAllChildrenCheckbox()
    {
        $planos = $this->planoRepository->findAllChildren();
        $vPlano = array();
        foreach ($planos as $plano){
            $vPlano[$plano->id] = ['checked' => 'false', 'titulo' => $plano->titulo];
        }

        return $vPlano;
    }

    public function insertUserPlanos($id, $planos)
    {
        return $this->planoRepository->insertUserPlanos($id, $planos);
    }

    public function create($params)
    {
        return $this->planoRepository->create($params);
    }

    public function update($id, $params)
    {
        return $this->planoRepository->update($id, $params);
    }
}