<?php
/**
 * Created by PhpStorm.
 * User: hugomachado
 * Date: 29/08/15
 * Time: 23:06
 */

namespace App\Contracts;


interface BairroRepositoryInterface {

    public function listBairroByCidade($id);
} 