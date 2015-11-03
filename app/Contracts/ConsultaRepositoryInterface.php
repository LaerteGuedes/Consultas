<?php


namespace App\Contracts;


interface ConsultaRepositoryInterface 
{

    public function listAllForCalendarByUser($id);

    public function checkIfAgendado($data);

    public function listarConsultasFuturasByUser($id);

    public function listarConsultasHistoricoByUser($id);

    public function confirmarConsulta($data);

    public function realizarConsulta($data);

    public function listarConsultasByProfissional($id,$data);

} 