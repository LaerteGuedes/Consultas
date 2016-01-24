<?php

namespace App\Repositories;

use App\Contracts\UserAssinaturaRepositoryInterface;
use App\Repository;
use App\UserAssinatura;
use Illuminate\Support\Facades\DB;

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

    public function expiraAssinaturasPeriodoTestes()
    {
        $query = DB::table('user_assinaturas as ua')
            ->join('users as u', 'u.id', '=', 'ua.user_id')
            ->select('ua.id', 'ua.user_id', 'u.name', 'u.email','ua.assinatura_status')
            ->where('ua.assinatura_status', '=', 'PERIODO_TESTES')
            ->where('ua.expiracao', '<', DB::raw('now()'));
        $affected = $query->get();
        $query->update(['ua.assinatura_status' => 'PERIODO_TESTES_SUSPENSO']);
        return $affected;
    }


}