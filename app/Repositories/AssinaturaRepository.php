<?php

namespace App\Repositories;

use App\Assinatura;
use App\Contracts\AssinaturaRepositoryInterface;
use App\Repository;
use Illuminate\Support\Facades\DB;

class AssinaturaRepository extends Repository implements AssinaturaRepositoryInterface
{
    public function __construct(Assinatura $assinatura)
    {
        $this->model = $assinatura;
    }

    public function assinaturasAdm()
    {
        return DB::table('assinaturas as a')
            ->leftJoin('user_assinaturas as ua', 'a.id', '=', 'ua.assinatura_id')
            ->select('a.id', 'a.titulo', 'a.valor', 'a.numero_parcelas', DB::raw('(CASE WHEN ua.id IS NULL THEN 1 ELSE 0 END) AS pode_excluir'))
            ->groupBy('a.id')
            ->get();
    }
}