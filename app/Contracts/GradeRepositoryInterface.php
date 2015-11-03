<?php

namespace App\Contracts;


interface GradeRepositoryInterface {

	public function getDiasSemanais();

	public function getDiaSemanal($key);

	public function getHorariosByUser($id , $data);

	public function save($id,$data);

	public function getHorarioFuncionamentoPorLocalidadeByUser($user_id,$localidade_id);

	public function getHorariosPorLocalidadeByUser($user_id,$localidade_id,$dia_semana,$turno);
} 