<?php

namespace App\Repositories;

use App\Assinatura;
use App\Contracts\AssinaturaRepositoryInterface;
use App\Repository;

class AssinaturaRepository extends Repository implements AssinaturaRepositoryInterface
{
    public function __construct(Assinatura $assinatura)
    {
        $this->model = $assinatura;
    }
}