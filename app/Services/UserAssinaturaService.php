<?php
/**
 * Created by PhpStorm.
 * User: laerte
 * Date: 16/12/15
 * Time: 15:57
 */

namespace App\Services;

use App\Contracts\UserAssinaturaRepositoryInterface;
use App\Service;

class UserAssinaturaService extends Service
{
    public function __construct(UserAssinaturaRepositoryInterface $userAssinaturaRepository)
    {
        $this->repository = $userAssinaturaRepository;
    }

    public function expiraAssinaturas()
    {
        $userAssinaturas = $this->repository->getAllExpiradas();
        if (count($userAssinaturas)){
            foreach ($userAssinaturas as $assinatura){
                $this->repository->expirarAssinatura($assinatura);
            }
        }
    }

    public function expiraAssinaturasPeriodoTestes()
    {
       return $this->repository->expiraAssinaturasPeriodoTestes();
    }

}