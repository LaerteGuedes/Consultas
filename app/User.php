<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{

    use Authenticatable, CanResetPassword, SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'lastname','email', 'password','phone','role_id','cid','active','thumbnail','views'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function role()
    {
        return $this->hasOne('App\Role', 'id', 'role_id');

    }

    public function agendas()
    {
        return $this->hasMany('App\Agenda','user_id','id');
    }

    public function grades()
    {
        return $this->hasMany('App\Grade','user_id','id');
    }

    public function consultas()
    {
        return $this->hasMany('App\Consulta','user_id','id');
    }

    public function consultasProfissionais()
    {
        return $this->hasMany('App\Consulta','profissional_id','id');
    }

    public function localidades()
    {
        return $this->hasMany('App\Localidade','user_id','id');
    }

    public function curriculos()
    {
        return $this->hasMany('App\Curriculo','user_id','id');
    }

    public function servicos()
    {
        return $this->hasMany('App\Servico','user_id','id');
    }

    public function especialidade()
    {
        return $this->hasOne('App\UserEspecialidade','user_id');
    }

    public function ramos()
    {
        return $this->hasMany('App\UserRamo','user_id','id');
    }

    public function comentarios()
    {
        return $this->hasMany('App\Comentario','comentado','id');
    }

    public function comentadores()
    {
        return $this->hasMany('App\Comentario','user_id','id');
    }

    public function avaliadores()
    {
        return $this->hasMany('App\Avaliacao','avaliador','id');
    }

    public function avaliados()
    {
        return $this->hasMany('App\Avaliacao','user_id','id');
    }

    public function planos(){
        return $this->belongsToMany('App\Plano', 'user_planos', 'user_id', 'plano_id');
    }


    public function hasRole($roles)
    {
        $this->have_role = $this->getUserRole();

        // Check if the user is a root account
        if($this->have_role->name == 'Root') {
            return true;
        }

        if(is_array($roles)){
            foreach($roles as $need_role){
                if($this->checkIfUserHasRole($need_role)) {
                    return true;
                }
            }
        } else{
            return $this->checkIfUserHasRole($roles);
        }
        return false;
    }

    private function getUserRole()
    {
        return $this->role()->getResults();
    }

    private function checkIfUserHasRole($need_role)
    {
        return (strtolower($need_role)==strtolower($this->have_role->name)) ? true : false;
    }
}
