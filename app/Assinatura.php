<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assinatura extends Model
{
    CONST AVALIACAO = 1;
    CONST PAGO = 2;
    CONST SUSPENSO = 3;

    protected $fillable = ['titulo', 'valor', 'numero_parcelas'];

    public function users()
    {
        return $this->hasMany('App\User', 'assinatura_id', 'id');
    }
}
