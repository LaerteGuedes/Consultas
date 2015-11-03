<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use App\Http\Requests\RegisterUserRequest;
use App\Http\Controllers\Controller;

use App\Services\UserService;
use App\Services\MessageService;

use App\Services\EstadoService;
use App\Services\EspecialidadeService;

class HomeController extends Controller
{

    protected $userService;
    protected $messageService;
    protected $estadoService;
    protected $especialidadeService;

    public function __construct(UserService $userService , 
                                MessageService $messageService,
                                EstadoService $estadoService,
                                EspecialidadeService $especialidadeService)
    {
        $this->userService    = $userService;
        $this->messageService = $messageService;

        $this->estadoService = $estadoService;
        $this->especialidadeService = $especialidadeService;
    }

    public function index()
    {
        if(\Auth::guest())
        {
            $estados = $this->estadoService->listCombo();
            $especialidades = $this->especialidadeService->listCombo();

            return view('home.home')->with([

                'estados' => $estados,
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
