<?php

namespace App\Services;

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

    public function __construct(GradeRepositoryInterface $gradeRepositoryInterface)
    {
        $this->repository = $gradeRepositoryInterface;
    }
    public function getHorariosPorLocalidadeByUser($user_id,$localidade_id,$dia_semana,$turno)
    {
        return  $this->repository->getHorariosPorLocalidadeByUser($user_id,$localidade_id,$dia_semana,$turno);
    }

    public function getHorarioFuncionamentoPorLocalidadeByUser($user_id,$localidade_id)
    {
        return  $this->repository->getHorarioFuncionamentoPorLocalidadeByUser($user_id,$localidade_id);
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
        $j = 0;

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