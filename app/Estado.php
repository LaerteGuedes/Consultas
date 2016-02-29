<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estado extends Model
{
   // use SoftDeletes;

    protected $fillable = ['uf','nome'];


    public function cidades()
    {
        return $this->hasMany('App\Cidade','uf','uf');
    }

}
