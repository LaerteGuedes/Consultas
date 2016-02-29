<?php

namespace App\Services;

use App\Contracts\ConsultaRepositoryInterface;
use App\Custom\Debug;
use App\Service;
use App\Contracts\GradeRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class GradeService extends Service
{

    protected $turnos = [

        'm' => 'manhã',
        't' => 'tarde',
        'n' => 'noite'
    ];

    protected $consultaRepository;

    public function __construct(GradeRepositoryInterface $gradeRepository, ConsultaRepositoryInterface $consultaRepository)
    {
        $this->repository = $gradeRepository;
        $this->consultaRepository = $consultaRepository;
    }

    public function getHorariosByLocalidade($localidade_id)
    {
        return $this->repository->getHorariosByLocalidade($localidade_id);
    }

    public function getHorariosPorLocalidadeByUser($user_id,$localidade_id,$dia_semana,$turno)
    {
        return $this->repository->getHorariosPorLocalidadeByUser($user_id,$localidade_id,$dia_semana,$turno);
    }

    public function getHorariosByLocalidadeAndUserMinMax($user_id, $localidade_id, $dia_semana,$turno)
    {
        return $this->repository->getHorariosByLocalidadeAndUserMinMax($user_id,$localidade_id,$dia_semana,$turno);
    }

    public function getHorariosByLocalidadeAndUser($user_id, $localidade_id)
    {
        return $this->repository->getHorariosByLocalidadeAndUser($user_id, $localidade_id);
    }

    public function getHorariosAtualPorLocalidadeByUser($user_id, $localidade_id, $dia_semana, $data, $turno){
        $data_atual = date('Y-m-d');
        $horario_atual = date('H:i:s');

        if ($data >= $data_atual){
            if ($data == $data_atual){
                $horarios = $this->repository->getHorariosPorLocalidadeByUserAndHorario($user_id, $localidade_id, $dia_semana, $turno, $horario_atual);
            }else{
                $horarios = $this->repository->getHorariosPorLocalidadeByUser($user_id, $localidade_id, $dia_semana, $turno);
            }

            if ($horarios->count()){
                foreach ($horarios as $key => $horario) {
                    $is_agendado = $this->checkIfAgendado([
                        'profissional_id' => $user_id,
                        'localidade_id'   => $localidade_id,
                        'data_agenda'     => $data,
                        'horario_agenda'  => $horario->horario
                    ]);
                    if ($is_agendado){
                        $horarios->pull($key);
                    }
                }

                return $horarios->toArray();
            }

            return false;
        }

        return false;

    }

    public function checkIfAgendado($data)
    {
        return $this->consultaRepository->checkIfAgendado($data);
    }

    public function getHorarioFuncionamentoPorLocalidadeByUser($user_id,$localidade_id)
    {
        return  $this->repository->getHorarioFuncionamentoPorLocalidadeByUser($user_id,$localidade_id);
    }

    public function getAllHorariosTurno($user_id, $data)
    {
        $turnos = ['m' => 'Manhã', 't' => 'Tarde', 'n' => 'Noite'];
        $diasSemana = ['seg', 'ter', 'qua', 'qui', 'sex', 'sab', 'dom'];
        $data = ['localidade_id' => $data['localidade_id'], 'turno' => 'm'];

        $aux = 0;
        foreach ($turnos as $sigla => $turno){
            foreach ($diasSemana as $dia) {
                $data['turno'] = $sigla;
                $data['dia_semana'] = $dia;
                $grade[$aux]['turno_sigla'] = $sigla;
                $grade[$aux]['turno_nome'] = $turno;
                $grade[$aux]['dias'][$dia] = $this->repository->getHorariosByUser($user_id, $data);
            }
            $aux++;
        }

        return $grade;
    }

    public function getTurnos()
    {
        return $this->turnos;
    }

    public function getDiasSemanais()
    {
        return $this->repository->getDiasSemanais();
    }

    public function getDiaSemanal($key)
    {
        return $this->repository->getDiaSemanal($key);
    }

    public function getHorariosByUser($id , $data)
    {
        return $this->repository->getHorariosByUser($id , $data);
    }
    public function save($id,$data){

        return $this->repository->save($id,$data);
    }

    public function cancelarDia($user_id, $localidade_id, $dia_semana)
    {
        return $this->repository->cancelarDia($user_id, $localidade_id, $dia_semana);
    }


    public function getHoras($i=6,$f=20)
    {

        while($i<=$f)
        {
            $data[] = str_pad($i,2,0, STR_PAD_LEFT);
            $i++;
        }

        return $data;
    }

    public function getIntervalos()
    {
        $j = 0;

        while($j<60)
        {
            if($j%5 == 0)
            {
                $data[] = str_pad($j,2,0, STR_PAD_LEFT);
            }
            $j++;
        }


        return $data;
    }
    public function getIntervalosAbreviados()
    {
        $j = 5;

        while($j<190)
        {
            if($j<60)
            {
                if($j%5 == 0)
                {
                    $data[] = str_pad($j,2,0, STR_PAD_LEFT);
                }
            }else
            {
                if($j%30 == 0)
                {
                    $data[] = str_pad($j,2,0, STR_PAD_LEFT);
                }
            }

            $j++;
        }

        return $data;

    }

} 