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

    public function isAssinaturaVigente($user_id)
    {
        $userAssinaturas = $this->repository->getAssinaturaVigente($user_id);
        if (count($userAssinaturas)){
            return true;
        }
        return false;
    }

    public function hasAssinaturaTestes($user_id)
    {
        $userAssinatura = $this->repository->getAssinaturaTeste($user_id);
        if (isset($userAssinatura->id)){
            return true;
        }
        return false;
    }

    public function getAssinaturaTestes($user_id)
    {
        return $this->repository->getAssinaturaTeste($user_id);
    }

}