<?php
/**
 * Created by PhpStorm.
 * User: hugomachado
 * Date: 29/08/15
 * Time: 23:07
 */

namespace App\Repositories;

use App\Contracts\EstadoRepositoryInterface;
use App\Repository;
use App\Estado;

class EstadoRepository extends Repository implements EstadoRepositoryInterface
{

    public function __construct(Estado $estado)
    {
        $this->model = $estado;
    }

    public function listCombo()
    {
        return $this->model->lists('uf','uf');
    }


    public function listarEstadosApi()
    {
    	return  $this->model->orderBy('uf')->get(['uf','nome']);  
    }




} 