<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Grade extends Model
{
   // use SoftDeletes;

    protected $fillable =['user_id','localidade_id','dia_semana','turno','horario'];

    protected $dias_semanais = [

            'seg' => 'Segunda-feira',
            'ter' => 'Terça-feira',
            'qua' => 'Quarta-feira',
            'qui' => 'Quinta-feira',
            'sex' => 'Sexta-feira',
            'sab' => 'Sábado',
            'dom' => 'domingo',

        ];


    public function getDiasSemanais()
    {
        return $this->dias_semanais;
    }

    public function getDiaSemanal($key)
    {
        return $this->dias_semanais[$key];
    }    

    public function user()
    {
    	return $this->belongsTo('App\User','user_id','id');
    }
    public function localidade()
    {
    	return $this->belongsTo('App\Localidade','localidade_id','id');
    }
}
