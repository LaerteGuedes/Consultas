<?php

namespace App\Http\Controllers;

use App\Custom\Debug;
use App\Custom\Util;
use App\Services\CidadeService;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Services\EstadoService;
use App\Services\UserService;
use App\Services\EspecialidadeService;
use App\Services\GradeService;
use App\Services\LocalidadeService;
use App\Services\CalendarService;
use App\Services\ConsultaService;
use App\Services\ComentarioService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfissionalController extends Controller
{
    protected $estadoService;
    protected $userService;
    protected $especialidadeService;
    protected $gradeService;
    protected $localidadeService;
    protected $consultaService;
    protected $comentarioService;
    protected $cidadeService;

    public function __construct(EstadoService $estadoService,
                                UserService $userService,
                                EspecialidadeService $especialidadeService,
                                GradeService $gradeService,
                                LocalidadeService $localidadeService,
                                CalendarService $calendarService,
                                ConsultaService $consultaService,
                                ComentarioService $comentarioService,
                                CidadeService $cidadeService)
    {
        $this->estadoService        = $estadoService;
        $this->userService          = $userService;
        $this->especialidadeService = $especialidadeService;
        $this->gradeService         = $gradeService;
        $this->localidadeService    = $localidadeService;
        $this->calendarService      = $calendarService;
        $this->consultaService      = $consultaService;
        $this->comentarioService    = $comentarioService;
        $this->cidadeService        = $cidadeService;
    }


    public function detalhe($id)
    {
        $user =  $this->userService->find($id);
        if (isset(Auth::user()->id)){
            $comentarios = $this->userService->comentariosPorUsuario(Auth::user()->id, $id);
        }else{
            $comentarios = array();
        }

        $dias_semanais = $this->gradeService->getDiasSemanais();
        $planos = $user->planos()->get();
        $this->userService->atualizarViewProfissional($user->id);

        return view('profissional.detalhe')->with([
            'user' => $user,
            'comentarios' => $comentarios,
            'planos' => $planos,
            'dias_semanais' => $dias_semanais
        ]);
    }

    public function agendar($user_id,$localidade_id, Request $request)
    {

        $user =  $this->userService->find($user_id);
        $localidade = $this->localidadeService->find($localidade_id);
        $diaDeHoje = date('Y-m-d');
        $horarioAtual = date('h:i:s');
        $cidades = $this->cidadeService->listCidadesAreaMetropolitanaBelemList();

        $diasSemanais = $this->gradeService->getDiasSemanais();

        $turnos = $this->gradeService->getTurnos();
        if ($request->get('next')) {
            $semanaAtual = $this->calendarService->getNextSemana($request->get('next'));
        }
        elseif($request->get('previous')){
            $semanaAtual = $this->calendarService->getPreviousSemana($request->get('previous'));
        }else {
            $semanaAtual = $this->calendarService->getSemanaAtual();
        }

        return view('profissional.agendar')->with([
            'user' => $user,
            'localidade' => $localidade,
            'dias_semanais' => $diasSemanais,
            'semana_atual' => $semanaAtual,
            'turnos'       => $turnos,
            'dia_de_hoje'  => $diaDeHoje,
            'horario_atual' => $horarioAtual,
            'cidades' => $cidades
        ]);
    }

    public function confirmar(Request $request)
    {
        Debug::dump($request->all());
        $usuario      = $this->userService->find($request->get('user_id'));
        $profissional = $this->userService->find($request->get('profissional_id'));
        $localidade   = $this->localidadeService->find($request->get('localidade_id'));

        $planosAtendidos = $profissional->planos()->get();
        $planoUsuario = $usuario->planos()->first();

        $planoAtendido = false;

        if ($planoUsuario){
            foreach ($planosAtendidos as $plano) {
                if ($planoUsuario->id == $plano->id){
                    $planoAtendido = $plano;
                    break;
                }
            }
        }

        return view('profissional.confirmar')->with([
            'usuario'      => $usuario,
            'profissional' => $profissional,
            'localidade'   => $localidade,
            'dia_agenda'   => $request->get('dia_agenda'),
            'horario_agenda' => $request->get('horario_agenda'),
            'planoAtendido' => $planoAtendido
        ]);
    }

    public function finalizar(Request $request)
    {
        $request->merge(['status'=>'AGUARDANDO']);

        if($this->consultaService->create($request->all()))
        {
            return redirect()->route('profissional.agendamento.confirmado');
        }
    }

    public function confirmado()
    {
        return view('profissional.confirmado');
    }
}
