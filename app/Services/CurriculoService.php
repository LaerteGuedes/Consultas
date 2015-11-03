<?php

namespace App\Services;

use App\Contracts\CurriculoRepositoryInterface;
use App\Service;

class CurriculoService extends Service
{
    public function __construct(CurriculoRepositoryInterface $curriculoRepositoryInterface)
    {
        $this->repository = $curriculoRepositoryInterface;
    }
    public function paginateByUser($id)
    {
        return $this->repository->paginateByUser($id);
    }

} 