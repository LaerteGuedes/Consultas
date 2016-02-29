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

    public function byUser($id)
    {
        return $this->repository->byUser($id);
    }
    public function paginateByUser($id)
    {
        return $this->repository->paginateByUser($id);
    }

} 