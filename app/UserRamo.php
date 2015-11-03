<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserRamo extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id','ramo_id'];

    public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }
    public function ramo()
    {
        return $this->belongsTo('App\Ramo','ramo_id','id');
    }
}
