<?php

namespace App\Http\Controllers;


use App\Custom\Debug;
use App\Services\MailService;
use App\Services\PlanoService;
use Illuminate\Http\Request;

use App\Http\Requests\RegisterUserRequest;
use App\Http\Controllers\Controller;

use App\Services\UserService;
use App\Services\MessageService;

use App\Services\EstadoService;
use App\Services\EspecialidadeService;
use App\Services\CidadeService;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    protected $userService;
    protected $messageService;
    protected $estadoService;
    protected $especialidadeService;
    protected $cidadeService;
    protected $planoService;
    protected $mailService;

    public function __construct(UserService $userService ,
                                MessageService $messageService,
                                EstadoService $estadoService,
                                EspecialidadeService $especialidadeService,
                                CidadeService $cidadeService,
                                PlanoService $planoService,
                                MailService $mailService)

    {
        $this->userService    = $userService;
        $this->messageService = $messageService;
        $this->cidadeService = $cidadeService;
        $this->estadoService = $estadoService;
        $this->especialidadeService = $especialidadeService;
        $this->planoService = $planoService;
        $this->mailService = $mailService;
    }

    public function index()
    {
        if(\Auth::guest())
        {
            $estados = $this->estadoService->listCombo();
            $cidades = $this->cidadeService->listCidadesAreaMetropolitanaBelem();
            $especialidades = $this->especialidadeService->listCombo();

            return view('home.home')->with([

                'estados' => $estados,
                'cidades' => $cidades,
                'especialidades' => $especialidades,

            ]);
        }else{
            return redirect()->route('dashboard');
        }
    }
    public function homeCliente()
    {
        $planos = $this->planoService->findParents();
        return view('home.home-cliente')->with(array('planos' => $planos));
    }

    public function homeProfissional()
    {
        return view('home.home-profissional');
    }

    public function registerUser(RegisterUserRequest $request)
    {
        $user_id = $this->userService->register($request->all());
        if ($user_id){
            $planos = array($request->input('id_plano'));
            $this->planoService->insertUserPlanos(Auth::user()->id, $planos);
            $this->mailService->sendBoasVindas(Auth::user());
            return redirect()->route('dashboard');
        }
        return back()->withErrors([$this->messageService->getMessage('error')]);
    }
}
