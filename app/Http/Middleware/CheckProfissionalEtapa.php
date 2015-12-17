<?php

namespace App\Http\Middleware;

use App\Custom\Debug;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckProfissionalEtapa
{
    public function handle($request, Closure $next)
    {
        $route = $this->routeEtapa($request);

        if($route){
            return redirect()->route($route);
        }else{
            return $next($request);
        }
    }

    public function routeEtapa($request)
    {
        $user = \Auth::user();
        $routeName = $request->route()->getName();

        if (!isset($user->id)){
            return 'home.profissional';
        }

        $localidade = $user->localidades()->count();

        $rotas = [
            'store.localidade',
            'update.localidade',
            'store.assinatura'
        ];

        if(in_array($routeName,$rotas))
        {
            return false;
        }

        if (($routeName == 'etapa.grade' || $routeName == 'etapa.assinatura') && !$localidade){
            return 'etapa.localidade';
        }

        $grade = $user->grades()->count();

        if (($routeName == 'etapa.assinatura') && !$grade){
            return 'etapa.grade';
        }

        $assinatura = $user->userAssinatura()->count();

        if (!($routeName == 'etapa.localidade' || $routeName == 'etapa.grade' || $routeName == 'etapa.assinatura') && !$assinatura){
            return 'etapa.assinatura';
        }

        return false;
    }

}