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

    public function getAssinaturaVigente($user_id)
    {
        $userAssinaturas = $this->model->where('user_id', '=', $user_id)
            ->where('expiracao', '>', 'now()')
            ->where('assinatura_status', '=', 'TESTES')
            ->orWhere('assinatura_status', '=', 'PAGO')
            ->get();
        return $userAssinaturas;
    }

    public function getAssinaturaTeste($user_id)
    {
        return $this->model->where('user_id', '=', $user_id)->where('assinatura_status', '=', 'PERIODO_TESTES')->first();
    }
}