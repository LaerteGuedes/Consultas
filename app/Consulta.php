<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Consulta extends Model
{
   // use SoftDeletes;

    protected $fillable = [
        'user_id','pessoal','outro','nota','status',
        'profissional_id','localidade_id','data_agenda','horario_agenda', 'id_plano'
    ];

    public function listStatus()
    {
        return [

            'INFO'       => 'Informação',
            'AGUARDANDO' => 'Aguardando Confirmação',
            'CONFIRMADA' => 'Confirmada',
            'REALIZADA'  => 'Realizada',
            'CANCELADA'  => 'Cancelada'
        ];
    }

    public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }

    public function plano()
    {
        return $this->hasOne('App\Plano', 'id', 'id_plano');
    }
     public function profissional()
    {
        return $this->belongsTo('App\User','profissional_id','id');
    }
     public function localidade()
    {
        return $this->belongsTo('App\Localidade','localidade_id','id');
    }
    public function avisos()
    {
        return $this->hasMany('App\Aviso'.'consulta_id','id');
    }
}
