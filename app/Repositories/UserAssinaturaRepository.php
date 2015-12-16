<?php

namespace App\Repositories;

use App\Contracts\UserAssinaturaRepositoryInterface;
use App\Repository;
use App\UserAssinatura;

class UserAssinaturaRepository extends Repository implements UserAssinaturaRepositoryInterface
{

    public function __construct(UserAssinatura $userAssinatura)
    {
        $this->model = $userAssinatura;
    }

    public function getAllExpiradas()
    {
        return $this->model->where('expiracao', '<', date('Y-m-d h:i:s'))
            ->where('assinatura_status', '=', 'PERIODO_TESTES')->get();
    }

    public function expirarAssinatura($userAssinatura)
    {
        $userAssinatura->assinatura_status = 'SUSPENSO';
        $userAssinatura->save();
    }

}