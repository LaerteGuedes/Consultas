<?php

namespace App\Repositories;

use App\Contracts\GradeRepositoryInterface;
use App\Repository;
use App\Grade;
use App\User;
use Mockery\CountValidator\Exception;
use Symfony\Component\Debug\Debug;

class GradeRepository extends Repository implements GradeRepositoryInterface
{

    public function __construct(Grade $grade)
    {
        $this->model = $grade;
    }

    public function cancelarDia($user_id, $localidade_id, $dia_semana)
    {
        return $this->model->where('user_id', $user_id)->where('localidade_id', $localidade_id)
            ->where('dia_semana', $dia_semana)->delete();
    }

    public function getHorariosPorLocalidadeByUser($user_id,$localidade_id,$dia_semana,$turno)
    {
        return $this->model->where('user_id',$user_id)
            ->where('localidade_id',$localidade_id)
            ->where('dia_semana',$dia_semana)
            ->where('turno',$turno)
            ->orderBy('horario','asc')
            ->get();
    }

    public function getHorariosPorLocalidadeByUserAndHorario($user_id, $localidade_id, $dia_semana, $turno, $horario)
    {
        return $this->model->where('user_id',$user_id)
            ->where('localidade_id',$localidade_id)
            ->where('dia_semana',$dia_semana)
            ->where('turno',$turno)
            ->where('horario', '>', $horario)
            ->orderBy('horario','asc')
            ->get();
    }

    public function getHorarioFuncionamentoPorLocalidadeByUser($user_id,$localidade_id)
    {
        $dias_semanais = $this->model->getDiasSemanais();
        $turnos         = ['m','t','n'];

        $data = [];

        foreach($dias_semanais as $dia_semana => $dia)
        {

            foreach($turnos as $turno)
            {
                $minimo = $this->model->where('user_id',$user_id)
                    ->where('localidade_id',$localidade_id)
                    ->where('dia_semana',$dia_semana)
                    ->where('turno',$turno)
                    ->min('horario');

                $maximo = $this->model->where('user_id',$user_id)
                    ->where('localidade_id',$localidade_id)
                    ->where('dia_semana',$dia_semana)
                    ->where('turno',$turno)
                    ->max('horario');

                if($minimo && $maximo)
                {
                    $data[$dia_semana][$turno] = [

                        'minimo' => $minimo,
                        'maximo' => $maximo
                    ];
                }
            }

        }

        return $data;
    }


    public function getDiasSemanais()
    {
        return $this->model->getDiasSemanais();
    }

    public function getDiaSemanal($key)
    {
        return $this->model->getDiaSemanal($key);
    }

    public function getHorariosByUser($id , $data)
    {


        return $this->model->where('user_id',$id)
            ->where('localidade_id',$data['localidade_id'])
            ->where('dia_semana',$data['dia_semana'])
            ->where('turno',$data['turno'])
            ->orderBY('horario','asc')
            ->get();
    }

    public function isHorariosIncompativeis($user_id, $horario, $dia_semana, $localidades)
    {
        if ($this->model->where('user_id', $user_id)->where('horario', $horario)
                        ->where('dia_semana', $dia_semana)->whereIn('localidade_id', $localidades)->count()){
            return true;
        }else{
            return false;
        }
    }

    public function save($id,$data)
    {
        if(isset($data['dias']))
        {
            foreach($data['dias'] as $dia_semana)
            {
                $this->createGrade( $id, $data , $dia_semana);
            }
        }

        return $this->createGrade( $id , $data);
    }

    public function createGrade(  $userid , $data , $dia_semana = false )
    {
        $hora_inicio = $data['hora_inicio'] . ':' .$data['minuto_inicio'] . ':00';
        $hora_final  = $data['hora_final']  . ':' .$data['minuto_final']  . ':00';
        $intervalo   = $data['intervalo'];
        $inicio = strtotime($hora_inicio);
        $final  = strtotime($hora_final);
        $user = new User();
        $localidades = $user->find($userid)->localidades()->get();
        $localidades_id = array();


        foreach ($localidades as $localidade) {
            $localidades_id[] = $localidade->id;
        }

        while($inicio <= $final)
        {
            if(!isset($horario))
            {
                $horario = $hora_inicio;
            }



            $dia = $dia_semana <> false ? $dia_semana : $data['dia_semana'];

            if ($this->isHorariosIncompativeis($userid,$horario, $dia, $localidades_id)){
                $arr = array('horario' => $horario);
                return $arr;
            }

            if(!$this->model->where('localidade_id',$data['localidade_id'])
                ->where('turno',$data['turno'])
                ->where('dia_semana',$dia)
                ->where('user_id',$userid)
                ->where('horario',$horario)
                ->first(['id']))
            {
                $this->create([

                    'user_id'       => $userid,
                    'localidade_id' => $data['localidade_id'],
                    'dia_semana'    => $dia,
                    'turno'         => $data['turno'],
                    'horario'       => $horario

                ]);
            }

            $horario = date('H:i:s', strtotime(  $horario  .' + ' . $intervalo . ' minute '));
            $inicio  = strtotime($horario);
        }

        return true;

    }

} 