<?php

namespace App\Http\Middleware;

use App\Custom\Debug;
use App\Role;
use Closure;
use Illuminate\Contracts\Auth\Guard;

class AdmAuthenticate
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if ($this->auth->guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->route('adm.login');
            }
        }


        if (!($this->auth->user() && $this->auth->user()->role_id == Role::ADMINISTRADOR)){

            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->route('adm.login');
            }
        }

        return $next($request);
    }
}
