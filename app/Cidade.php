<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cidade extends Model
{
    use SoftDeletes;

    protected $fillable = ['uf','nome'];

    public function estado()
    {
        return $this->belongsTo('App\Estado','uf','uf');
    }

    public function localidades()
    {
        return $this->hasMany('App\Localidade','cidade_id','id');
    }

    public function bairros()
    {
        return $this->hasMany('App\Bairro','cidade_id','id');
    }

}
