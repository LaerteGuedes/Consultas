<?php


namespace App\Services;

use App\Service;
use App\Contracts\ComentarioRepositoryInterface;

class ComentarioService extends Service
{

    public function __construct(ComentarioRepositoryInterface $comentarioRepositoryInterface)
    {
        $this->repository = $comentarioRepositoryInterface;

    }

    public function getTotalComentarioProfissional($id)
    {
    	return $this->repository->getTotalComentarioProfissional($id);
    }

} 