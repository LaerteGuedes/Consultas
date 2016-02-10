<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ramo extends Model
{
   // use SoftDeletes;

    protected $fillable = ['especialidade_id','nome'];


    public function especialidade()
    {
        return $this->belongsTo('App\Especialidade','especialidade_id','id');
    }

    public function userRamos()
    {
        return $this->hasMany('App\UserRamo','ramo_id','id');
    }
}
