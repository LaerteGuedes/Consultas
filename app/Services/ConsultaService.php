<?php

namespace App\Services;

use App\Custom\Debug;
use App\Service;
use App\Contracts\ConsultaRepositoryInterface;


class ConsultaService extends Service
{

    public function __construct(ConsultaRepositoryInterface $consultaRepositoryInterface)
    {
        $this->repository = $consultaRepositoryInterface;
    }

    public function listarConsultasByProfissional($id,$data)
    {
        return $this->repository->listarConsultasByProfissional($id,$data);
    }

    public function realizarConsulta($data)
    {
        return $this->repository->realizarConsulta($data);
    }

    public function noShow($data)
    {
        return $this->repository->noShow($data);
    }

    public function confirmarConsulta($data)
    {
        return $this->repository->confirmarConsulta($data);
    }

    public function listAllForCalendarByUser($id)
    {
        return $this->repository->listAllForCalendarByUser($id);
    }

    public function listarConsultasFuturasByUserWithProfissional($id)
    {
        return $this->repository->listarConsultasFuturasByUserWithProfissional($id);
    }

    public function listarConsultasDatasFuturas($id)
    {
        return $this->repository->listarConsultasDatasFuturas($id);
    }

    public function listarConsultasDatasHistorico($id)
    {
        return $this->repository->listarConsultasDatasHistorico($id);
    }

    public function listarConsultasHistoricoByUserAndDate($id, $data_agenda)
    {
        return $this->repository->listarConsultasHistoricoByUserAndDate($id, $data_agenda);
    }

    public function listarConsultasFuturasByUserAndDate($id, $data_agenda)
    {
        return $this->repository->listarConsultasFuturasByUserAndDate($id, $data_agenda);
    }

    public function listarConsultasFuturasByWithUser($id)
    {
        return $this->repository->listarConsultasFuturasByWithUser($id);
    }

    public function listarConsultasHistoricoByUserWithProfissional($id)
    {
        return $this->repository->listarConsultasHistoricoByUserWithProfissional($id);
    }

    public function listarConsultasFuturasByUser($id)
    {
        return $this->repository->listarConsultasFuturasByUser($id);
    }

    public function listarConsultasHistoricoByUser($id)
    {
        return $this->repository->listarConsultasHistoricoByUser($id);
    }

    public function listarConsultasHistoricoByWithUser($id)
    {
        return DB::table('consultas')
            ->join('users', 'consultas.profissional_id', '=', 'users.id')
            ->where('user_id', $id)
            ->where('status', '<>', 'AGUARDANDO')
            ->where('data_agenda', '>', date('Y-m-d'))
            ->orderBy('data_agenda','desc')
            ->get();
    }


    public function checkIfAgendado($data)
    {
        return $this->repository->checkIfAgendado($data);
    }

    public function countAgendadas()
    {
        return $this->repository->countAgendadas();
    }

    public function countRealizadas()
    {
        return $this->repository->countRealizadas();
    }

    public function countCanceladas()
    {
        return $this->repository->countCanceladas();
    }

    public function create(array $data)
    {
    	if(isset($data['outro']) && !empty($data['outro']))
    	{
    			$data['pessoal'] = 0;
    	}else{
            if (isset($data['id_plano'])){
                $data['id_plano'] = ($data['id_plano']) ? $data['id_plano'] : null;
            }
            $data['pessoal'] = 1;
        }

    	return $this->repository->create($data);
    }
    public function getTotalConsultasFuturasByUser($id)
     {
        return $this->repository->getTotalConsultasFuturasByUser($id);
     
     }



} 