<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Localidade extends Model
{
   // use SoftDeletes;

    protected $fillable = ['user_id','uf','cidade_id','bairro_id','logradouro','numero',
                            'complemento','cep','tipo','preco'
                            ];

    protected $tipos = ['DOMICILIO'=>'Domiciliar ( Home Care )','CONSULTORIO'=>'Endereço Fixo'];

    public function getTipos()
    {
        return $this->tipos;
    }

    public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }

    public function cidade()
    {
        return $this->hasOne('App\Cidade','id','cidade_id');
    }
    public function bairro()
    {
        return $this->hasOne('App\Bairro','id','bairro_id');
    }

    public function agendas()
    {
        return $this->hasMany('App\Agenda','localidade_id','id');
    }
    public function grades()
    {
        return $this->hasMany('App\Grade','localidade_id','id');
    }
    public function consultas()
    {
        return $this->hasMany('App\Consulta','localidade_id','id');
    }
}
