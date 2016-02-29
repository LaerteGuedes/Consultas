<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Avaliacao extends Model
{
    protected $fillable = ['user_id','avaliador','nota'];

    public function profissional()
    {
    	return $this->belongsTo('App\User','user_id','id');
    }
    public function user()
    {
    	return $this->belongsTo('App\User','avaliador','id');
    }
}
