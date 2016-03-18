<?php

namespace App\Http\Controllers\Auth;

use App\Custom\Debug;
use App\Services\UserService;
use Illuminate\Http\Request;


use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    protected $userService;

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    protected $redirectTo = '/dashboard';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $rules = [
            'name'     => 'required|min:2|max:255|alpha',
            'lastname' => 'required|min:2|max:255|alpha',
            'phone'    => 'required|min:15|max:15',
            'email'    => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:5|max:10'

        ];

        $messages = [

            'name.required'     => 'O nome é obrigatório',
            'lastname.required' => 'O sobrenome é obrigatório',

            'name.min'     => 'O nome deve conter no minimo 2 caracteres',
            'lastname.min' => 'O sobrenome deve conter no minimo 2 caracteres',

            'name.max'     => 'O nome deve conter no maximo 255 caracteres',
            'lastname.max' => 'O sobrenome deve conter no maximo 255 caracteres',

            'name.alpha'     => 'O nome deve conter somente letras',
            'lastname.alpha' => 'O sobrenome deve conter somente letras',

            'phone.required'    => 'O  telefone é obrigatório',

            'phone.min'    => 'O  telefone é inválido',

            'phone.max'    => 'O  telefone é inválido',


        ];

        if(isset($data['cid'])){
            $rules['cid']='required';
        }


        return Validator::make($data, $rules,$messages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
       $data['password'] = bcrypt($data['password']);

       if(isset($data['cid']))
       {
            $data['role_id'] = 3;

       }else{

           $data['role_id'] = 2;
       }

        return User::create($data);
    }



    protected function getCredentials(Request $request)
    {
        $credentials = array_merge(['active'=> 1],$request->only($this->loginUsername(), 'password'));

        return $credentials;
    }


}
