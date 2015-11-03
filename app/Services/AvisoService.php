<?php

namespace App\Services;

use App\Service;
use App\Contracts\AvisoRepositoryInterface;

class AvisoService extends Service
{

    public function __construct(AvisoRepositoryInterface $avisoRepositoryInterface)
    {
        $this->repository = $avisoRepositoryInterface;

    }

	public function listarAvisosByCliente($id)
	{
		return $this->repository->listarAvisosByCliente($id);
	}

	public function listarAvisosByProfissional($id)
	{
		return $this->repository->listarAvisosByProfissional($id); 
	}

	public function getTotalAvisosPendentesByCliente($id)
	{
		return $this->repository->getTotalAvisosPendentesByCliente($id);

	}

	public function getTotalAvisosPendentesByProfissional($id)
	{

		return $this->repository->getTotalAvisosPendentesByProfissional($id);

	}

	public function atualizaViewByCliente($id)
	{

		return $this->repository->atualizaViewByCliente($id);

	}

	public function atualizaViewByProfissional($id)
	{

		return $this->repository->atualizaViewByProfissional($id);

	}


} 