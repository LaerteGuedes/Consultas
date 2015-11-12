<?php

namespace App\Http\Controllers;


use App\Custom\Debug;
use Illuminate\Http\Request;

use App\Http\Requests\RegisterUserRequest;
use App\Http\Controllers\Controller;

use App\Services\UserService;
use App\Services\MessageService;

use App\Services\EstadoService;
use App\Services\EspecialidadeService;
use App\Services\CidadeService;

class HomeController extends Controller
{

    protected $userService;
    protected $messageService;
    protected $estadoService;
    protected $especialidadeService;
    protected $cidadeService;

    public function __construct(UserService $userService , 
                                MessageService $messageService,
                                EstadoService $estadoService,
                                EspecialidadeService $especialidadeService,
                                CidadeService $cidadeService)

    {
        $this->userService    = $userService;
        $this->messageService = $messageService;
        $this->cidadeService = $cidadeService;
        $this->estadoService = $estadoService;
        $this->especialidadeService = $especialidadeService;
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
        return view('home.home-cliente');
    }

    public function homeProfissional()
    {
        return view('home.home-profissional');
    }

    public function registerUser(RegisterUserRequest $request)
    {
        if($this->userService->register($request->all()))
        {
            return redirect()->route('dashboard');
        }

        return back()->withErrors([$this->messageService->getMessage('error')]);
    }
}
