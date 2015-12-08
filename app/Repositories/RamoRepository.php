<?php

namespace App\Repositories;

use App\Repository;
use App\Contracts\RamoRepositoryInterface;
use App\Ramo;

class RamoRepository extends Repository implements RamoRepositoryInterface
{

    public function __construct(Ramo $ramo)
    {
        $this->model = $ramo;
    }

   	public function listarRamoByEspecialidade($especialidade_id)
   	{
   		return $this->model->where('especialidade_id',$especialidade_id)->orderBy('nome','asc')->get(['id','nome']);
   	}

    public function listarRamoByEspecialidadeCombo($especialidade_id)
    {
        return $this->model->where('especialidade_id',$especialidade_id)->orderBy('nome','asc')->lists('nome','id');
    }
} 