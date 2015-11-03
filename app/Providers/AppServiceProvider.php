<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->bind('path.public', function() {
          
          if(is_dir( base_path().'/public' ))
          {
            return base_path().'/public';
          }

          if(is_dir( base_path().'/salus.yetilab.net' ))
          {
            return base_path().'/salus.yetilab.net';
          }

          if(is_dir( base_path().'/public_html' ))
          {
            return base_path().'/public_html';
          }

          if(is_dir( base_path().'/www' ))
          {
            return base_path().'/www';
          }

        });

        $this->app->bind(
                'App\Contracts\UserRepositoryInterface',
                'App\Repositories\UserRepository'
            );
        $this->app->bind(
            'App\Contracts\EspecialidadeRepositoryInterface',
            'App\Repositories\EspecialidadeRepository'
        );
        $this->app->bind(
            'App\Contracts\UserEspecialidadeRepositoryInterface',
            'App\Repositories\UserEspecialidadeRepository'
        );
        $this->app->bind(
            'App\Contracts\CurriculoRepositoryInterface',
            'App\Repositories\CurriculoRepository'
        );
        $this->app->bind(
            'App\Contracts\ServicoRepositoryInterface',
            'App\Repositories\ServicoRepository'
        );
        $this->app->bind(
            'App\Contracts\RamoRepositoryInterface',
            'App\Repositories\RamoRepository'
        );
        $this->app->bind(
            'App\Contracts\UserRamoRepositoryInterface',
            'App\Repositories\UserRamoRepository'
        );
        $this->app->bind(
            'App\Contracts\LocalidadeRepositoryInterface',
            'App\Repositories\LocalidadeRepository'
        );
        $this->app->bind(
            'App\Contracts\EstadoRepositoryInterface',
            'App\Repositories\EstadoRepository'
        );
        $this->app->bind(
            'App\Contracts\CidadeRepositoryInterface',
            'App\Repositories\CidadeRepository'
        );
        $this->app->bind(
            'App\Contracts\BairroRepositoryInterface',
            'App\Repositories\BairroRepository'
        );
        $this->app->bind(
            'App\Contracts\AgendaRepositoryInterface',
            'App\Repositories\AgendaRepository'
        );
        $this->app->bind(
            'App\Contracts\ConsultaRepositoryInterface',
            'App\Repositories\ConsultaRepository'
        );
        $this->app->bind(
            'App\Contracts\GradeRepositoryInterface',
            'App\Repositories\GradeRepository'
        );
        $this->app->bind(
            'App\Contracts\AvisoRepositoryInterface',
            'App\Repositories\AvisoRepository'
        );
        $this->app->bind(
            'App\Contracts\ComentarioRepositoryInterface',
            'App\Repositories\ComentarioRepository'
        );
        $this->app->bind(
            'App\Contracts\AvaliacaoRepositoryInterface',
            'App\Repositories\AvaliacaoRepository'
        );
    }
}
