<?php
/**
 * Created by PhpStorm.
 * User: hugomachado
 * Date: 29/08/15
 * Time: 20:12
 */

namespace App\Repositories;

use App\Contracts\UserRamoRepositoryInterface;
use App\Repository;
use App\UserRamo;
use Illuminate\Support\Facades\DB;


class UserRamoRepository extends Repository implements UserRamoRepositoryInterface
{

    public function __construct(UserRamo $userRamo)
    {
        $this->model = $userRamo;
    }

    public function byUser($id)
    {
        return DB::table('user_ramos as ur')
            ->join("ramos as r", "r.id", '=', 'ur.ramo_id')
            ->select('ur.id', 'r.nome')
            ->where('ur.user_id', '=', $id)
            ->groupBy('ur.id')
            ->get();
    }


    public function byRamo($id)
    {
        return DB::table('user_ramos as ur')
            ->join("ramos as r", "r.id", '=', 'ur.ramo_id')
            ->select('ur.id', 'r.nome', 'r.id')
            ->where('ur.user_id', '=', $id)
            ->groupBy('ur.id')
            ->get();
    }

    public function paginateByUser($id)
    {
        return $this->model->whereHas('user', function ($q) use ($id) {

            $q->where('user_id', $id);

        })->paginate();
    }
} 