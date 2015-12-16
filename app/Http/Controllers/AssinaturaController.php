<?php
namespace App\Http\Controllers;

use App\Custom\Debug;
use App\Services\AssinaturaService;
use App\Services\MailService;
use App\Services\MessageService;
use App\Services\PagSeguroService;
use App\Services\UserAssinaturaService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\CountValidator\Exception;

class AssinaturaController extends Controller
{
    protected $pagSeguroService;
    protected $assinaturaService;
    protected $messageService;
    protected $userService;
    protected $mailService;
    protected $userAssinaturaService;

    public function __construct(PagSeguroService $pagSeguroService, AssinaturaService $assinaturaService,
                                MessageService $messageService, UserService $userService,
                                MailService $mailService, UserAssinaturaService $userAssinaturaService)
    {
        $this->pagSeguroService = $pagSeguroService;
        $this->assinaturaService = $assinaturaService;
        $this->messageService = $messageService;
        $this->userService = $userService;
        $this->mailService = $mailService;
        $this->userAssinaturaService = $userAssinaturaService;
    }

    public function teste(){
        $this->pagSeguroService->sendAssinaturaRequest();
        return view("assinatura.teste");
    }

    public function nova(){
        $user_id = \Auth::user()->id;
        $assinaturas = $this->assinaturaService->all();

        return view("assinatura.nova")->with(['assinaturas' => $assinaturas, 'user_id' => $user_id]);
    }

    public function store(Request $request){
        $params = $request->all();
        $params['expiracao'] = date('Y-m-d h:i:s', strtotime("+30 days"));

        $this->userService->saveUserAssinatura($request->get('user_id'), $request->all());
        $urlPagSeguro = $this->assinaturaService->sendRequestPagSeguro($request->get('user_id'), $request->get('assinatura_id'));

        return redirect()->away($urlPagSeguro);
    }

    public function expiraAssinaturas()
    {
        $this->userAssinaturaService->expiraAssinaturas();
    }

    public function notificacao(Request $request)
    {
        $response = $this->pagSeguroService->consultaStatusByNotificacaoAssinatura($request->get('notificationCode'));
        $this->assinaturaService->alteraAssinaturaByStatus($response->status, $response->reference);
    }

}