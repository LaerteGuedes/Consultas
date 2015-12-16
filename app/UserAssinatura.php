<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAssinatura extends Model
{
    protected $table = 'user_assinaturas';
    protected $fillable = ['user_id', 'assinatura_id', 'assinatura_status', 'expiracao'];

    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }

    public function assinatura(){
        return $this->hasOne('App\Assinatura', 'assinatura_id');
    }
}
