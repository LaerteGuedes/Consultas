<?php

namespace App\Http\Controllers;

use App\Custom\Debug;
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

	public function __construct(EstadoService $estadoService,
								UserService $userService,
								EspecialidadeService $especialidadeService,
								GradeService $gradeService,
								LocalidadeService $localidadeService,
								CalendarService $calendarService,
								ConsultaService $consultaService,
								ComentarioService $comentarioService)
	{
		$this->estadoService        = $estadoService;
		$this->userService          = $userService;
		$this->especialidadeService = $especialidadeService;
		$this->gradeService         = $gradeService;
		$this->localidadeService    = $localidadeService;
		$this->calendarService      = $calendarService;
		$this->consultaService      = $consultaService;
		$this->comentarioService    = $comentarioService;
	}


	public function detalhe($id)
	{
		$user =  $this->userService->find($id);
		$comentarios = $this->userService->comentariosPorUsuario(Auth::user()->id);
		$dias_semanais = $this->gradeService->getDiasSemanais();

		$this->userService->atualizarViewProfissional($user->id);

		return view('profissional.detalhe')->with([
				'user' => $user,
				'comentarios' => $comentarios,
				'dias_semanais' => $dias_semanais
			]);
	}

	public function agendar($user_id,$localidade_id, Request $request)
	{

		$user =  $this->userService->find($user_id);
		$localidade = $this->localidadeService->find($localidade_id);
		$dias_semanais = $this->gradeService->getDiasSemanais();
		$turnos        = $this->gradeService->getTurnos();
		if ($request->get('next')) {
			$semana_atual = $this->calendarService->getNextSemana($request->get('next'));
		}
		elseif($request->get('previous')){
			$semana_atual = $this->calendarService->getPreviousSemana($request->get('previous'));
		}else {
			$semana_atual = $this->calendarService->getSemanaAtual();
		}		
		
		return view('profissional.agendar')->with([

				'user' => $user,
				'localidade' => $localidade,
				'dias_semanais' => $dias_semanais,
				'semana_atual' => $semana_atual,
				'turnos'       => $turnos
			]);
	}

	public function confirmar(Request $request)
	{
		
		$usuario      = $this->userService->find($request->get('user_id'));
		$profissional = $this->userService->find($request->get('profissional_id'));
		$localidade   = $this->localidadeService->find($request->get('localidade_id'));

		return view('profissional.confirmar')->with([
				'usuario'      => $usuario,
				'profissional' => $profissional,
				'localidade'   => $localidade,
				'dia_agenda'   => $request->get('dia_agenda'),
				'horario_agenda' => $request->get('horario_agenda')
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
