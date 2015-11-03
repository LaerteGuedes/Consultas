<?php
/**
 * Created by PhpStorm.
 * User: hugomachado
 * Date: 07/09/15
 * Time: 21:14
 */

namespace App\Repositories;


use App\Contracts\AgendaRepositoryInterface;
use App\Repository;
use App\Agenda;

class AgendaRepository extends Repository implements AgendaRepositoryInterface
{

    public function __construct(Agenda $agenda)
    {
        $this->model = $agenda;
    }

    public function paginateByuser($id)
    {
        return $this->model->where('user_id',$id)->orderBy('data_agenda','desc')->orderBy('horario_agenda','desc')->paginate();
    }



    public function listForCalendarByUser($id)
    {
        $res = $this->model->where('user_id',$id)->orderBy('data_agenda','desc')->orderBy('horario_agenda','desc')->get();
        $data = [];

        if($res)
        {

            foreach($res as $row)
            {
                $obj = new \stdClass();

                $localidade = sprintf("%s - %s %s, %s, %s - %s",$row->localidade->getTipos()[$row->localidade->tipo]   ,
                    $row->localidade->logradouro,
                    $row->localidade->numero,
                    $row->localidade->bairro->nome,
                    $row->localidade->cidade->nome,
                    $row->localidade->uf);

                $obj->title      = date("H:i",strtotime($row->horario_agenda));
                $obj->localidade = $localidade;
                $obj->date       = $row->data_agenda;
                $obj->horario    = $row->horario_agenda;
                $obj->id         = $row->id;

                $data[] = $obj;

                unset($obj);
            }
        }

        return $data;
    }

    public function checkIfExists($data)
    {
        $res = $this->model->where('user_id',$data['user_id'])
                           ->where('localidade_id',$data['localidade_id'])
                           ->where('data_agenda',$data['data_agenda'])
                           ->where('horario_agenda',$data['horario_agenda'])
                           ->first();

        return $res ? true : false;
    }

    public function checkIfBusy($id)
    {
        $res = $this->model->find($id) ;

        if($res)
        {
            if($res->consultas()->first())
                return true;
        }

        return false;
    }

} 