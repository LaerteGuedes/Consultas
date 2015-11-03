<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agenda extends Model
{
    use SoftDeletes;

    protected $fillable = [ 'user_id','localidade_id' , 'data_agenda' , 'horario_agenda','nota'];


    public function getHora($str)
    {
        $ex = explode(":",$str);
        $hora = reset($ex);

        return $hora;
    }

    public function getMinutos($str)
    {
        $ex = explode(":",$str);
        $min = $ex[1];

        return $min;
    }

    public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }
    public function localidade()
    {
        return $this->belongsTo('App\Localidade','localidade_id','id');
    }

    public function consultas()
    {
        return $this->hasMany('App\Consulta','agenda_id','id');
    }
}
