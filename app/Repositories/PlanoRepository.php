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

    public function findParentsById($id)
    {
        return DB::table('planos')
            ->join("user_planos", 'user_planos.plano_id', '=', 'planos.id')
            ->join("users", 'user_planos.user_id', '=', 'users.id')
            ->join("planos as p", 'planos.id_pai', '=', 'p.id')
            ->select("p.id", 'p.titulo')
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