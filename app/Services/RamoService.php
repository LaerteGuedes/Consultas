<?php

namespace App\Services;

use App\Service;
use App\Contracts\RamoRepositoryInterface;


class RamoService extends  Service
{

    public function __construct(RamoRepositoryInterface $ramoRepositoryInterface)
    {
        $this->repository = $ramoRepositoryInterface;
    }
  	public function listarRamoByEspecialidade($especialidade_id)
    {
        return $this->repository->listarRamoByEspecialidade($especialidade_id);
    }

    public function listarRamoByEspecialidadeCombo($especialidade_id)
    {
        return $this->repository->listarRamoByEspecialidadeCombo($especialidade_id);
    }

    public function getByNome($nome)
    {
        return $this->repository->getByNome($nome);
    }

    public function listarRamosApi($especialidade_id)
    {
        $data = [];

    	$rows = $this->repository->listarRamoByEspecialidade($especialidade_id);

        if($rows)
        {
            foreach ($rows as $row) {
            
                    $nome = ucwords($row->nome);

                    $data[] = [ 

                        'id'   => $row->id,
                        'nome' => $nome
                    ];      
             }   

        }
 		
 		return $data;
    }
} 