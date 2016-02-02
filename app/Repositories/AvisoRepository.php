<?php

namespace App\Repositories;

use App\Repository;
use App\Contracts\AvisoRepositoryInterface;
use App\Aviso;
use Illuminate\Support\Facades\DB;


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

	public function listarAvisosDetalhesByUser($id)
	{
		return DB::table('avisos')
            ->join('consultas', 'avisos.consulta_id', '=', 'consultas.id')
            ->join('users', 'consultas.profissional_id', '=', 'users.id')
            ->join('user_especialidades', 'users.id', '=', 'user_especialidades.user_id')
            ->join('especialidades', 'user_especialidades.especialidade_id', '=', 'especialidades.id')
            ->where('avisos.cliente_id', $id)
            ->select('avisos.id', 'avisos.created_at', 'consultas.data_agenda', 'avisos.nota', 'avisos.tipo', 'users.name', 'especialidades.nome as especialidade')
            ->limit(30)
            ->get();
	}

	public function listarAvisosDetalhesByProfissional($id)
	{
		return DB::table('avisos')
			->join('consultas', 'avisos.consulta_id', '=', 'consultas.id')
			->join('users', 'consultas.user_id', '=', 'users.id')
			->where('avisos.profissional_id', $id)
			->select('avisos.id', 'avisos.created_at', 'consultas.data_agenda', 'avisos.nota', 'avisos.tipo', 'users.name', 'users.lastname')
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






