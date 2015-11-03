<?php
/**
 * Created by PhpStorm.
 * User: hugomachado
 * Date: 29/08/15
 * Time: 22:58
 */

namespace App\Contracts;


interface LocalidadeRepositoryInterface {

    public function getTipos();
    public function paginateByUser($id);
    public function listForComboByUser($id);
} 