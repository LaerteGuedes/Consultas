<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    CONST ADMINISTRADOR = 1;
    CONST CLIENTE = 2;
    CONST PROFISSIONAL = 3;
    CONST COLABORADOR = 4;

    use SoftDeletes;

    protected $fillable= ['name','description'];

    public function users()
    {
        return $this->hasMany('App\User', 'role_id', 'id');
    }
}
