<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aviso extends Model
{
    use SoftDeletes;

    protected $table = 'avisos';

    protected $fillable = ['consulta_id','profissional_id','cliente_id','nota','tipo','profissional_view','cliente_view'];

    public function consulta()
    {
    	return $this->belongsTo('App\Consulta','consulta_id','id');
    }
}
