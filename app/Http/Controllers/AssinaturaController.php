<?php
namespace App\Http\Controllers;

use App\Custom\Debug;
use App\Services\AssinaturaService;
use App\Services\MailService;
use App\Services\MessageService;
use App\Services\PagSeguroService;
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

    public function __construct(PagSeguroService $pagSeguroService, AssinaturaService $assinaturaService,
                                MessageService $messageService, UserService $userService,
                                MailService $mailService)
    {
        $this->pagSeguroService = $pagSeguroService;
        $this->assinaturaService = $assinaturaService;
        $this->messageService = $messageService;
        $this->userService = $userService;
        $this->mailService = $mailService;
    }

    public function teste(){
        $this->pagSeguroService->sendAssinaturaRequest();
        return view("assinatura.teste");
    }

    public function nova(){
        $assinaturas = $this->assinaturaService->all();
        $user_id = \Auth::user()->id;

        return view("assinatura.nova")->with(['assinaturas' => $assinaturas, 'user_id' => $user_id]);
    }

    public function store(Request $request){
        DB::beginTransaction();
        try{
            $this->userService->updateAssinaturaAvaliacao($request->get('user_id'), $request->all());
            $urlPagSeguro = $this->assinaturaService->sendRequestPagSeguro($request->get('user_id'), $request->get('assinatura_id'));
            DB::commit();
        }catch (Exception $e){
            DB::rollBack();
        }

        return redirect()->away($urlPagSeguro);
    }

    public function notificacao(Request $request)
    {
        $response = $this->pagSeguroService->consultaStatusByNotificacaoAssinatura($request->get('notificationCode'));
        $this->assinaturaService->alteraAssinaturaByStatus($response->status, $response->reference);
    }

}