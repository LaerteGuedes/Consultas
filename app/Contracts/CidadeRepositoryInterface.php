<?php
/**
 * Created by PhpStorm.
 * User: hugomachado
 * Date: 29/08/15
 * Time: 23:05
 */

namespace App\Contracts;


interface CidadeRepositoryInterface {

    public function listCidadesByUf($uf);

} 