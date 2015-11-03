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


class UserRamoRepository extends Repository implements UserRamoRepositoryInterface
{

    public function __construct(UserRamo $userRamo)
    {
        $this->model = $userRamo;
    }

    public function paginateByUser($id)
    {
        return $this->model->whereHas('user', function ($q) use ($id) {

            $q->where('user_id', $id);

        })->paginate();
    }
} 