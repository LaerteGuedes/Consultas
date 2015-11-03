<?php
/**
 * Created by PhpStorm.
 * User: hugomachado
 * Date: 28/08/15
 * Time: 21:05
 */

namespace App\Contracts;


interface ServicoRepositoryInterface {

    public function paginateByUser($id);

    public function checkUserHasItem($user_id,$id);
} 