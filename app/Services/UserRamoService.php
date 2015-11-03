<?php
/**
 * Created by PhpStorm.
 * User: hugomachado
 * Date: 29/08/15
 * Time: 20:14
 */

namespace App\Services;

use App\Contracts\UserRamoRepositoryInterface;
use App\Service;

class UserRamoService extends  Service
{
    public function __construct(UserRamoRepositoryInterface $userRamoRepositoryInterface){

        $this->repository = $userRamoRepositoryInterface;
    }

    public function paginateByUser($id)
    {
        return $this->repository->paginateByUser($id);
    }
} 