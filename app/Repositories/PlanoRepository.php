<?php
/**
 * Created by PhpStorm.
 * User: laerteguedes
 * Date: 07/11/15
 * Time: 08:54
 */

namespace App\Repositories;


use App\Custom\Debug;
use App\Plano;
use App\Repository;
use App\User;
use Illuminate\Support\Facades\DB;

class PlanoRepository extends Repository
{
    /**
     * PlanoRepository constructor.
     */
    public function __construct(Plano $plano)
    {
        $this->model = $plano;
    }

    public function paginateByUser($id){
        return $this->model->whereHas('user', function ($q) use ($id) {

            $q->where('user_id', $id);

        })->paginate();
    }

    public function findParents()
    {
        return $this->model->where('id_pai', '=', 0)->get();
    }

    public function findParentsAdm()
    {
        return DB::table('planos as p')
            ->leftJoin('planos as pc', 'p.id', '=', 'pc.id_pai')
            ->leftJoin('user_planos as up', 'pc.id', '=', 'up.plano_id')
            ->where('p.id_pai', '=', 0)
            ->select("p.id", 'p.titulo', DB::raw('(CASE WHEN up.plano_id IS NULL THEN 1 ELSE 0 END) AS pode_excluir'))
            ->groupBy('p.id')
            ->get();
    }

    public function findChildrenAdm($id)
    {
        return DB::table('planos as p')
            ->leftJoin('user_planos as up', 'p.id', '=', 'up.plano_id')
            ->where('id_pai', '=', $id)
            ->select("p.id", 'p.titulo', DB::raw('(CASE WHEN up.plano_id IS NULL THEN 1 ELSE 0 END) AS pode_excluir'))
            ->get();
    }

    public function findParentsById($id)
    {
        return DB::table('planos')
            ->join("user_planos", 'user_planos.plano_id', '=', 'planos.id')
            ->join("users", 'user_planos.user_id', '=', 'users.id')
            ->join("planos as p", 'planos.id_pai', '=', 'p.id')
            ->select("p.id", 'p.titulo')
            ->where('users.id', '=', $id)
            ->groupBy('planos.id_pai')
            ->get();
    }

    public function findChildrenById($id)
    {
        return DB::table('planos')
            ->join("user_planos", 'user_planos.plano_id', '=', 'planos.id')
            ->join("users", 'user_planos.user_id', '=', 'users.id')
            ->join("planos as p", 'planos.id', '=', 'p.id')
            ->select("p.id", 'p.titulo', 'p.id_pai')
            ->where('users.id', '=', $id)
            ->groupBy('planos.id')
            ->get();
    }

    public function findChildren($id){
        return $this->model->where('id_pai', '=', $id)->get(array('id', 'titulo'));
    }

    public function findAllChildren()
    {
        return $this->model->where('id_pai', '!=', 0)->get();
    }

    public function insertUserPlanos($id, $planos)
    {
        try{
            $user = User::find($id);
            $user->planos()->sync($planos);
        }catch (Exception $ex){
            echo $ex->getMessage();
            return false;
        }
        return true;
    }

}