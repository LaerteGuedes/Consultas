<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Servico extends Model
{
    use SoftDeletes;


    protected $fillable = ['user_id' ,'nome'];

    public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }
}
