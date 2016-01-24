<?php

namespace App\Http\Controllers;


use App\Custom\Debug;
use App\Services\MailService;
use App\Services\PlanoService;
use App\Services\UserEspecialidadeService;
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
    protected $userEspecialidadeService;

    public function __construct(UserService $userService ,
                                MessageService $messageService,
                                EstadoService $estadoService,
                                EspecialidadeService $especialidadeService,
                                CidadeService $cidadeService,
                                PlanoService $planoService,
                                MailService $mailService,
                                UserEspecialidadeService $userEspecialidadeService)

    {
        $this->userService    = $userService;
        $this->messageService = $messageService;
        $this->cidadeService = $cidadeService;
        $this->estadoService = $estadoService;
        $this->especialidadeService = $especialidadeService;
        $this->planoService = $planoService;
        $this->mailService = $mailService;
        $this->userEspecialidadeService = $userEspecialidadeService;
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
        $especialidades = $this->especialidadeService->all();
        return view('home.home-profissional')->with('especialidades', $especialidades);
    }

    public function registerUser(RegisterUserRequest $request)
    {
        $this->userService->register($request->all());
        $user = $this->userService->findBy('email', $request->get('email'));

        if ($request->has('especialidade_id')){
            $params = $request->all();
            $params['user_id'] = (isset($user->id)) ? $user->id : '';
            $this->userEspecialidadeService->create($params);
        }
        if (isset($user->id)){
            $planos = array($request->input('id_plano'));
            $this->planoService->insertUserPlanos(Auth::user()->id, $planos);
            $this->mailService->sendBoasVindas(Auth::user());

            return redirect()->route('dashboard');
        }
        return back()->withErrors([$this->messageService->getMessage('error')]);
    }
}
