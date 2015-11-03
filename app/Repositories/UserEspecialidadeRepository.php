<?php


namespace App\Repositories;

use App\Repository;
use App\Contracts\UserEspecialidadeRepositoryInterface;

use App\UserEspecialidade;

class UserEspecialidadeRepository extends  Repository implements  UserEspecialidadeRepositoryInterface{


        public function __construct(UserEspecialidade $userEspecialidade)
        {
            $this->model = $userEspecialidade;
        }

} 