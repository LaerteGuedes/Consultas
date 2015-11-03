<?php

namespace App\Repositories;

use App\Repository;
use App\Contracts\EspecialidadeRepositoryInterface;
use App\Especialidade;

class EspecialidadeRepository extends Repository implements EspecialidadeRepositoryInterface
{

    public function __construct(Especialidade $especialidade)
    {
        $this->model = $especialidade;
    }

    public function listCombo()
    {
        return $this->model->all()->lists('nome','id');
    }

} 