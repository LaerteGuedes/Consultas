<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Especialidade extends Model
{
  //  use SoftDeletes;

    protected $fillable = ['nome'];


    public function userEspecialidades()
    {
        return $this->hasMany('App\UserEspecialidade','especialidade_id','id');
    }

    public function ramos()
    {
        return $this->hasMany('App\Ramo','especialidade_id','id');
    }
}
