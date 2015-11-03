<?php
/**
 * Created by PhpStorm.
 * User: hugomachado
 * Date: 07/09/15
 * Time: 21:16
 */

namespace App\Services;

use App\Service;
use App\Contracts\AgendaRepositoryInterface;

class AgendaService extends Service
{

    public function __construct(AgendaRepositoryInterface $agendaRepositoryInterface)
    {
        $this->repository = $agendaRepositoryInterface;
    }

    public function paginateByUser($id)
    {
        return $this->repository->paginateByUser($id);
    }

    public function listForCalendarByUser($id)
    {
        return $this->repository->listForCalendarByUser($id);
    }

    public function checkIfExists($data)
    {
        return $this->repository->checkIfExists($data);
    }

    public function checkIfBusy($id)
    {
        return $this->repository->checkIfBusy($id);
    }

    public function getHoras()
    {
        $i = 6;

        while($i<=20)
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
    public function convertDateForDataBase($date)
    {
        $ex = explode('/',$date);
        $res = sprintf("%s-%s-%s",$ex[2],$ex[1],$ex[0]);

        return $res;
    }
    public function joinHoraMin($h,$m)
    {
        return sprintf( "%s:%s" ,$h , $m);
    }
} 