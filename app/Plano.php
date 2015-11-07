<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plano extends Model
{
    use SoftDeletes;

    public function parent(){
        return $this->belongsTo('App\Plano', "id_pai");
    }

    public function children(){
        return $this->hasMany('App\Plano', "id_pai");
    }

    public function user(){
        return $this->belongsToMany('App\User', 'user_planos', 'plano_id', 'user_id');
    }
}
