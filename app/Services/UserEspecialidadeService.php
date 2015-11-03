<?php
/**
 * Created by PhpStorm.
 * User: hugomachado
 * Date: 28/08/15
 * Time: 17:10
 */

namespace App\Services;

use App\Service;
use App\Contracts\UserEspecialidadeRepositoryInterface;


class UserEspecialidadeService extends Service {


    public function __construct(UserEspecialidadeRepositoryInterface $userEspecialidadeRepositoryInterface)
    {
        $this->repository = $userEspecialidadeRepositoryInterface;
    }

} 