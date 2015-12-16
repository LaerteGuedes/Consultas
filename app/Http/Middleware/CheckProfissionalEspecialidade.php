<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\Debug\Debug;

class CheckProfissionalEspecialidade
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if(!$this->check($request)){
            return redirect()->route('tutorial.inicial');
        }
        return $next($request);
    }

    public function check($request)
    {
        $rotas = [
            'edit.perfil',
            'update.perfil',
            'novo.localidade',
            'store.localidade',
            'update.localidade',
            'listar.cidades',
            'listar.bairros',
            'nova.assinatura',
            'store.assinatura'
        ];

        if(in_array($request->route()->getName() , $rotas ))
        {
            return true;
        }
        elseif($request->route()->getName() <> 'tutorial.inicial')
        {
            {
                if(!isset(\Auth::user()->especialidade->especialidade->nome) || !\Auth::user()->localidades()->count() )
                {
                    return false;
                }
                if(!isset(\Auth::user()->userAssinatura()->assinatura_id)){
                    return false;
                }
            }
        }

        return true;
    }
}
