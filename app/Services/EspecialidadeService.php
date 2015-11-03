<?php

namespace App\Services;

use App\Service;
use App\Contracts\EspecialidadeRepositoryInterface;

class EspecialidadeService extends Service
{

    public function __construct(EspecialidadeRepositoryInterface $especialidadeRepositoryInterface)
    {
        $this->repository = $especialidadeRepositoryInterface;
    }

    public function listCombo()
    {
        return $this->repository->listCombo();
    }

    public function listarEspecialidadesApi()
    {
        $rows = $this->repository->listCombo();

        foreach ($rows as $id => $nome) {
            
            $nome = ucwords($nome);

            $data[] = [

                'id'   => $id,
                'nome' => $nome
            ];
        }

        return $data;   
    }

} 