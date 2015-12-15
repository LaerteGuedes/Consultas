<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Support\Facades\Mail;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \App\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class
       // \App\Http\Middleware\VerifyCsrfToken::class,
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth'       => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'guest'      => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'roles' 	 => \App\Http\Middleware\CheckRole::class,
        'check.curriculo.user' 	 => \App\Http\Middleware\CheckCurriculoUser::class,
        'check.servico.user' 	 => \App\Http\Middleware\CheckServicoUser::class,
        'check.profissional.especialidade' => \App\Http\Middleware\CheckProfissionalEspecialidade::class,
        'cors' => \App\Http\Middleware\Cors::class,
        'admauth' => \App\Http\Middleware\AdmAuthenticate::class
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $user = null;
            Mail::send('emails.boasvindasusuario', ['user' => $user], function ($m) use ($user) {
                $m->from('noreply@sallus.net', 'Sallus - Secretaria Virtual');

                $m->to('laerteguedes8@gmail.com', 'Laerte Guedes')->subject('Bem-vindo!');
            });
        })->everyMinute();
    }
}
