<?php

namespace App\Repositories;

use App\Repository;
use App\Contracts\AvisoRepositoryInterface;
use App\Aviso;


class AvisoRepository extends Repository implements AvisoRepositoryInterface
{
    public function __construct(Aviso $aviso)
    {
        $this->model = $aviso;
    }

	public function listarAvisosByCliente($id)
	{
		return $this->model->where('cliente_id', $id)
							->orderBy('id','desc')
							->limit(30)
							->get();
	}

	public function listarAvisosByProfissional($id)
	{
		return $this->model->where('profissional_id', $id)
							->orderBy('id','desc')
							->limit(30)
							->get();
	}

	public function getTotalAvisosPendentesByCliente($id)
	{
		return $this->model->where('cliente_id', $id)
							->where('cliente_view',0)
							->orderBy('id','desc')
							->count();

	}

	public function getTotalAvisosPendentesByProfissional($id)
	{
		return $this->model->where('profissional_id', $id)
							->where('profissional_view',0)
							->orderBy('id','desc')
							->count();

	}

	public function atualizaViewByCliente($id)
	{
		return $this->model->where('cliente_id', $id)
							->where('cliente_view',0)
							->update(['cliente_view'=> 1]);
	}

	public function atualizaViewByProfissional($id)
	{

		return $this->model->where('profissional_id', $id)
							->where('profissional_view',0)
							->update(['profissional_view'=> 1]);

	}



} 






