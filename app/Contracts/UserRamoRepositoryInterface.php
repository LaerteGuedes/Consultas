<?php
/**
 * Created by PhpStorm.
 * User: hugomachado
 * Date: 29/08/15
 * Time: 20:12
 */

namespace App\Contracts;


interface UserRamoRepositoryInterface {

    public function paginateByUser($id);
} 