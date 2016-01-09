<?php

namespace App\Http\Controllers;

use App\Custom\Debug;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\UpdatePerfilRequest;
use App\Http\Controllers\Controller;

use App\Services\UserService;
use App\Services\EspecialidadeService;
use App\Services\MessageService;

class PerfilController extends Controller
{
    protected $userService;
    protected $especialidadeService;
    protected $messageService;

    public function __construct(UserService $userService ,
                                MessageService $messageService,
                                EspecialidadeService $especialidadeService
                                )
    {
        $this->userService    = $userService;
        $this->especialidadeService = $especialidadeService;
        $this->messageService = $messageService;
    }

    public function index()
    {

    }

    public function edit()
    {
        $especialidades = $this->especialidadeService->listCombo();

        return view('perfil.edit')->with([

            'especialidades' => $especialidades
        ]);
    }

    public function update($id, UpdatePerfilRequest $request)
    {
        if($this->userService->updatePerfil($id, $request))
        {
            return redirect()->route('dashboard')->with("message",$this->messageService->getMessage('success'));
        }

        return redirect()->route('edit.perfil')->withErrors([$this->messageService->getMessage('error')]);
    }

}
