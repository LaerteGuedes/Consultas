<?php
/**
 * Created by PhpStorm.
 * User: hugomachado
 * Date: 28/08/15
 * Time: 21:07
 */

namespace App\Services;

use App\Service;
use App\Contracts\ServicoRepositoryInterface;

class ServicoService extends  Service
{
    public function __construct(ServicoRepositoryInterface $servicoRepositoryInterface)
    {
        $this->repository = $servicoRepositoryInterface;
    }

    public function byUser($id)
    {
        return $this->repository->byUser($id);
    }

    public function paginateByUser($id)
    {
        return $this->repository->paginateByUser($id);
    }
} 