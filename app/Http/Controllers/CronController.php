<?php

namespace App\Http\Controllers;

use App\Custom\Debug;
use App\Services\MailService;
use App\Services\UserAssinaturaService;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CronController extends Controller
{


    protected $userAssinaturaService;
    protected $mailService;

    public function __construct(UserAssinaturaService $userAssinaturaService, MailService $mailService)
    {
        $this->userAssinaturaService = $userAssinaturaService;
        $this->mailService = $mailService;
    }

    public function expiraPeriodoTeste(Request $request)
    {
       $affectUsers =  $this->userAssinaturaService->expiraAssinaturasPeriodoTestes();

       if (sizeof($affectUsers)){
           foreach ($affectUsers as $user) {
               $this->mailService->sendNotificacaoExpiracaoTeste($user);
           }

       }

    }

}
