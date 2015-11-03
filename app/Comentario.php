<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comentario extends Model
{
    use SoftDeletes;

    protected $fillable = [
    	'user_id','comentado','descricao'
    ];

    public function profissional()
    {
    	return $this->belongsTo('App\User','comentado','id');
    }
    public function user()
    {
    	return $this->belongsTo('App\User','user_id','id');
    }
}
