<?php

namespace App\Http\Middleware;

use App\Custom\Debug;
use App\Role;
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
        $user = Auth::user();

        if ($user->role_id == Role::CLIENTE){
            return false;
        }

        $routeName = $request->route()->getName();

        if (!isset($user->id)){
            return 'home.profissional';
        }

        $localidade = $user->localidades()->count();

        $rotas = [
            'store.localidade',
            'update.localidade',
            'store.assinatura',
            'store.grade',
            'plano.ajaxplano',
            'plano.salvar',
            'delete.horario.grade',
            'delete.horario.grade.ajax',
            'grade.cancelardia',
            'grade.cancelardiaajax',
            'listar.bairros'
        ];

        if(in_array($routeName,$rotas))
        {
            return false;
        }

        if (($routeName == 'etapa.grade' || $routeName == 'etapa.plano' || $routeName == 'etapa.assinatura') && !$localidade){
            return 'etapa.localidade';
        }

        $grade = $user->grades()->count();

        if (($routeName == 'etapa.plano' || $routeName == 'etapa.assinatura') && !$grade){
            return 'etapa.grade';
        }

        $plano = $user->planos()->first();

        if (($routeName == 'etapa.assinatura') && (!$plano && !$user->nao_atende_planos)){
            return 'etapa.plano';
        }

        $assinatura = $user->userAssinatura()->first();

        if (!($routeName == 'etapa.localidade' || $routeName == 'etapa.grade' || $routeName == 'etapa.plano' || $routeName == 'etapa.assinatura') && !(isset($assinatura->id))){
            return 'etapa.assinatura';
        }else{
            if (isset($assinatura->id)){
                if (!($routeName == 'etapa.localidade' || $routeName == 'etapa.grade' || $routeName == 'etapa.plano' || $routeName == 'etapa.assinaturaaguardando') && $assinatura->assinatura_status == 'AGUARDANDO'){
                    return 'etapa.assinaturaaguardando';
                }


                if (!($routeName == 'etapa.localidade' || $routeName == 'etapa.grade' || $routeName == 'etapa.plano' || $routeName == 'etapa.assinatura' || $routeName == 'etapa.assinaturasuspensa') && ($assinatura->assinatura_status == 'SUSPENSO')){
                    return 'etapa.assinaturasuspensa';
                }

                if (!($routeName == 'etapa.localidade' || $routeName == 'etapa.grade' || $routeName == 'etapa.plano' || $routeName == 'etapa.assinatura' || $routeName == 'etapa.assinaturatestesuspensa') && ($assinatura->assinatura_status == 'PERIODO_TESTES_SUSPENSO') && ($user->usou_periodo_testes == 1)){
                    return 'etapa.assinaturatestesuspensa';
                }
            }
        }

        return false;
    }

}