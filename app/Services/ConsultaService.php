<?php

namespace App\Services;

use App\Consulta;
use App\Custom\Debug;
use App\Service;
use App\Contracts\ConsultaRepositoryInterface;
use App\User;


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

    public function listarConsultasFuturasByUserNotCancelada($id)
    {
        return $this->repository->listarConsultasFuturasByUserNotCancelada($id);
    }

    public function listarConsultasFuturasByProfissionalNotCancelada($id)
    {
        return $this->repository->listarConsultasFuturasByProfissionalNotCancelada($id);
    }

    public function listarConsultasFuturasByProfissional($id)
    {
        return $this->repository->listarConsultasFuturasByProfissional($id);
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

    public function cancelarAllConsultas(User $user, MailService $mail)
    {
        if ($user->role_id == User::CLIENTE){
            $consultas = $this->listarConsultasFuturasByUserNotCancelada($user->id);
        }elseif($user->role_id == User::PROFISSIONAL){
            $consultas = $this->listarConsultasFuturasByProfissionalNotCancelada($user->id);
        }


        if ($consultas->count()){
            foreach ($consultas as $consulta) {
                $this->cancelarConsulta($consulta, $mail, $user);
            }
        }
    }

    public function cancelarConsulta(Consulta $consulta, MailService $mail, User $user)
    {
        $params = ['resposta' => 'nao', 'consulta_id' => $consulta->id];
        $this->confirmarConsulta($params);

        $cliente = $consulta->user()->first();
        $profissional = $consulta->profissional()->first();

        if ($user->role_id == User::CLIENTE){
            $mail->consultaCanceladaPorCliente($cliente, $profissional, $consulta->data_agenda);
        }elseif($user->role_id == User::PROFISSIONAL){
            $mail->consultaCanceladaPorProfissional($cliente, $profissional, $consulta->data_agenda);
        }

        return true;
    }


    public function isConsultaMarcadaPorTurno($user_id, $profissional_id, $data_agenda, $horario_agenda)
    {
        if ($horario_agenda >= '05:00:00' && $horario_agenda <= '12:00:00'){
            $intervaloInicio = '05:00:00';
            $intervaloFinal = '12:00:00';
        }elseif ($horario_agenda > '12:00:00' && $horario_agenda <= '18:00:00'){
            $intervaloInicio = '12:01:00';
            $intervaloFinal = '18:00:00';
        }elseif ($horario_agenda > '18:00:00' && $horario_agenda <= '23:00:00'){
            $intervaloInicio = '18:01:00';
            $intervaloFinal = '23:00:00';
        }

        $consultas = $this->repository->getConsultasPorTurnoDia($user_id, $profissional_id, $intervaloInicio, $intervaloFinal, $data_agenda);

        $quant = $consultas->count();
        if ($quant > 0){
            return true;
        }

        return false;
    }

} 