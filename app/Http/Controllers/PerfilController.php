<?php

namespace App\Http\Controllers;

use App\Custom\Debug;
use App\Role;
use App\Services\ConsultaService;
use App\Services\MailService;
use App\Services\PlanoService;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\UpdatePerfilRequest;
use App\Http\Controllers\Controller;

use App\Services\UserService;
use App\Services\EspecialidadeService;
use App\Services\MessageService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PerfilController extends Controller
{
    protected $userService;
    protected $especialidadeService;
    protected $messageService;
    protected $consultaService;
    protected $mailService;
    protected $planoService;

    public function __construct(UserService $userService ,
                                MessageService $messageService,
                                EspecialidadeService $especialidadeService,
                                ConsultaService $consultaService,
                                MailService $mailService,
                                PlanoService $planoService
                                )
    {
        $this->userService    = $userService;
        $this->especialidadeService = $especialidadeService;
        $this->messageService = $messageService;
        $this->consultaService = $consultaService;
        $this->mailService = $mailService;
        $this->planoService = $planoService;
    }

    public function index()
    {

    }

    public function edit()
    {
        $especialidades = $this->especialidadeService->listCombo();
        $planos = $this->planoService->findParents();
        $planoAtual = Auth::user()->planos()->first();
        if (isset($planoAtual->id)){
            $operadoraAtual = $planoAtual->parent()->first();
        }else{
            $operadoraAtual = null;
        }

        if (!$operadoraAtual && !$planoAtual){
            $temPlano = false;
        }else{
            $temPlano = true;
        }

        return view('perfil.edit')->with([
            'planos' => $planos,
            'especialidades' => $especialidades,
            'planoAtual' => $planoAtual,
            'operadoraAtual' => $operadoraAtual,
            'temPlano' => $temPlano
        ]);
    }

    public function update($id, UpdatePerfilRequest $request)
    {
        if ($request->get('plano') == 2){
            $planos = array();
            $this->planoService->insertUserPlanos(Auth::user()->id, $planos);
        }elseif ($request->has('id_plano')){
            $planos = array($request->input('id_plano'));
            $this->planoService->insertUserPlanos(Auth::user()->id, $planos);
        }
        if($this->userService->updatePerfil($id, $request))
        {
            return redirect()->route('dashboard')->with("message",$this->messageService->getMessage('success'));
        }

        return redirect()->route('edit.perfil')->withErrors([$this->messageService->getMessage('error')]);
    }

    public function togglePerfilProfissionalUsuario(Request $request)
    {
        $user = Auth::user();
    //    Debug::dump($user,false);

        if ($user->role_id == Role::CLIENTE){
            $userToggled = $this->userService->findByEmailAndRole($user->email, Role::PROFISSIONAL);
        }elseif($user->role_id == Role::PROFISSIONAL){
            $userToggled = $this->userService->findByEmailAndRole($user->email, Role::CLIENTE);
        }

        Auth::logout();
        Session::flush();

        Auth::login($userToggled);

        return redirect()->route('dashboard');
    }

    public function cancelarConta()
    {
        return view("perfil.cancelar");
    }

    public function excluirConta()
    {
        $user = Auth::user();

        $this->userService->destroy($user->id);
        $this->consultaService->cancelarAllConsultas($user, $this->mailService);

        Auth::logout();
        return redirect("/")->with('message', 'Sua conta foi excluída!');
    }



}
