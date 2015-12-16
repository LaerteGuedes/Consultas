<?php
/**
 * Created by PhpStorm.
 * User: laerte
 * Date: 16/12/15
 * Time: 15:41
 */

namespace App\Contracts;


interface UserAssinaturaRepositoryInterface
{
    public function getAssinaturaVigente($user_id);
}