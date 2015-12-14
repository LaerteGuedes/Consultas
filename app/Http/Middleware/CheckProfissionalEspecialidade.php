<?php

namespace App\Http\Middleware;

use Closure;

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
            'listar.bairros'
        ];

      if(in_array($request->route()->getName() , $rotas ))
       {
            return true;
       }
        elseif($request->route()->getName() <> 'tutorial.inicial')
       {
            if(\Auth::user()->role->name=='Profissional')
            {
                if(!isset(\Auth::user()->especialidade->especialidade->nome) || !\Auth::user()->localidades()->count() )
                {
                    return false;
                }
                if(!isset(\Auth::user()->assinatura_id)){
                    return false;
                }
            }
       }


        return true;
    }
}
