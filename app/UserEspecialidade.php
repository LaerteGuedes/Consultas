<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserEspecialidade extends Model
{
  //  use SoftDeletes;

    protected $fillable = ['user_id','especialidade_id'];

    public function users()
    {
        return $this->hasMany('App\User','id','user_id');
    }

    public function especialidade()
    {
        return $this->belongsTo('App\Especialidade','especialidade_id','id');
    }
}
