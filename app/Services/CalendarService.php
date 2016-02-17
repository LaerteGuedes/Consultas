<?php

namespace App\Services;


use App\Custom\Debug;
use Carbon\Carbon;


class CalendarService
{
    public $meses = [

        1 =>'Janeiro',
        2 =>'Fevereiro',
        3 =>'Março',
        4 =>'Abril',
        5 =>'Maio',
        6 =>'Junho',
        7 =>'Julho',
        8 =>'Agosto',
        9 =>'Setembro',
        10 =>'Outubro',
        11 =>'Novembro',
        12 =>'Dezembro',

    ];

    protected $dias_semana = [

        'seg','ter','qua','qui','sex','sab','dom'
    ];

    public function getSemanaAtual()
    {
    
       $data = [];

       $inicio_semana = Carbon::now()->startOfWeek();
       $fim_semana    = Carbon::now()->endOfWeek();
       $contador = 0;

       while ($inicio_semana <= $fim_semana ) {
           
          $data[$this->dias_semana[$contador]]= $inicio_semana->toDateString();

          $inicio_semana->addDay();
          $contador++;
       }
       
       return $data;

    }


    public function getPreviousSemana($date)
    {
        $data = [];
        $explode = explode("-",$date);    
        $ano = $explode[0];
        $mes = $explode[1];
        $dia = $explode[2];
        $contador = 0;

       $inicio_semana = Carbon::create($ano,$mes,$dia)->subDays(7)->startOfWeek();
       $fim_semana    = Carbon::create($ano,$mes,$dia)->subDays(7)->endOfWeek();

       while ($inicio_semana <= $fim_semana ) {
           
          $data[$this->dias_semana[$contador]]= $inicio_semana->toDateString();

          $inicio_semana->addDay();
          $contador++;
       }

       return $data;
    }

    public function getCustomSemana($date)
    {
        $data = [];
        $explode = explode("-",$date);
        $ano = $explode[0];
        $mes = $explode[1];
        $dia = $explode[2];
        $contador = 0;

        $inicio_semana = Carbon::create($ano,$mes,$dia)->startOfWeek();
        $fim_semana    = Carbon::create($ano,$mes,$dia)->endOfWeek();

        while ($inicio_semana <= $fim_semana ) {

            $data[$this->dias_semana[$contador]]= $inicio_semana->toDateString();

            $inicio_semana->addDay();
            $contador++;
        }

        return $data;
    }

    public function getNextSemana($date)
    {
        $data = [];
        $explode = explode("-",$date);
        $ano = $explode[0];
        $mes = $explode[1];
        $dia = $explode[2];
        $contador = 0;

       $inicio_semana = Carbon::create($ano,$mes,$dia)->addDays(7)->startOfWeek();
       $fim_semana    = Carbon::create($ano,$mes,$dia)->addDays(7)->endOfWeek();

       while ($inicio_semana <= $fim_semana ) {
           
          $data[$this->dias_semana[$contador]]= $inicio_semana->toDateString();

          $inicio_semana->addDay();
          $contador++;
       }

       return $data;
    }

    public function getMesAtual()
    {
        return Carbon::now()->startOfMonth()->toDateString();
    }
    public function getNextMes($date)
    {
        $explode = explode("-",$date);    
        $ano = $explode[0];
        $mes = $explode[1];
        $dia = $explode[2];

        return Carbon::create($ano,$mes,$dia)->addMonth()->toDateString();
    }
    public function getPreviousMes($date)
    {
        $explode = explode("-",$date);    
        $ano = $explode[0];
        $mes = $explode[1];
        $dia = $explode[2];

        return Carbon::create($ano,$mes,$dia)->subMonth()->toDateString();
    }
} 