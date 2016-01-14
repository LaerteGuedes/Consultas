<?php
/**
 * Created by PhpStorm.
 * User: hugomachado
 * Date: 29/08/15
 * Time: 23:47
 */

namespace App\Services;

use App\Service;
use App\Contracts\BairroRepositoryInterface;

class BairroService extends Service
{

    public function __construct(BairroRepositoryInterface $bairroRepositoryInterface)
    {
        $this->repository = $bairroRepositoryInterface;
    }

    public function listBairroByCidade($id)
    {
        return $this->repository->listBairroByCidade($id);
    }

    public function listBairroByCidadeOnlyUnique($id)
    {
        return $this->repository->listBairroByCidadeOnlyUnique($id);
    }

} 