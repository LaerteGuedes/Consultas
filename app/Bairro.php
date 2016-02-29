<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bairro extends Model
{
    protected $fillable =['cidade_id','nome'];

    public function cidade()
    {
        return $this->belongsTo('App\Cidade','cidade_id','id');
    }
    public function localidades()
    {
        return $this->hasMany('App\Localidade','bairro_id','id');
    }
}
