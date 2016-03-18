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

    public function ativaCadastro($token)
    {
        $id = base64_decode($token);
        $user = $this->userService->find($id);

        if (isset($user) && !$user->active){
            $this->userService->ativaCadastroByEmail($user->email);
            return redirect()->to('auth/login')->with('message', 'Cadastro confirmado com sucesso! Faça login abaixo!');
        }

        return redirect()->route('home');
    }

    public function sobre()
    {
        return view("home.sobre");
    }

    public function politicaPrivacidade()
    {
        return view("home.politica-de-privacidade");
    }

    public function termosDeUso()
    {
        return view("home.termos-de-uso");
    }

    public function faleConosco()
    {
        return view("home.fale-conosco");
    }

    public function profissionalDeSaude()
    {
        return view("home.profissional-de-saude");
    }

    public function registerUser(RegisterUserRequest $request)
    {
        $requestUser = $request->all();
        $requestUser['active'] = 0;

        if ($request->has('cid')){
            $requestUser['perfil_medico_cliente'] = 1;
            $this->userService->registerUserProfissionalAndCliente($requestUser);
        }else{
            $this->userService->register($requestUser);
        }

        $user = $this->userService->findByEmail($request->get('email'));

        if ($request->has('especialidade_id')){
            $params = $request->all();
            $params['user_id'] = (isset($user->id)) ? $user->id : '';
         //   $params['active'] = 0;
            $this->userEspecialidadeService->create($params);
        }
        if (isset($user->id)){
            if ($request->input['id_plano']){
                $planos = array($request->input('id_plano'));
                $this->planoService->insertUserPlanos(Auth::user()->id, $planos);
            }

            $this->mailService->sendConfirmacaoCadastro($user, base64_encode($user->id));

            return redirect()->to('auth/login')->with('message', 'Um email de confirmação foi enviado. Confirme o seu cadastro e utilize nossos serviços!');
        }
        return back()->withErrors([$this->messageService->getMessage('error')]);
    }
}
