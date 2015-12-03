<?php

namespace App\Http\Controllers;

use App\Custom\Debug;
use App\Services\AvisoService;
use App\Services\LocalidadeService;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Services\UserService;
use App\Services\EstadoService;
use App\Services\CidadeService;
use App\Services\EspecialidadeService;
use App\Services\RamoService;
use App\Services\ComentarioService;
use App\Services\AvaliacaoService;


class ServerController extends Controller
{

	protected $userService;
	protected $estadoService;
	protected $cidadeService;
	protected $especialidadeService;
	protected $ramoService;
	protected $comentarioService;
	protected $avaliacaoService;
	protected $localidadeService;
	protected $avisoService;

	public function __construct(

		UserService          $userService,
		EstadoService        $estadoService,
		CidadeService        $cidadeService,
		EspecialidadeService $especialidadeService,
		RamoService          $ramoService,
		ComentarioService    $comentarioService,
		AvaliacaoService     $avaliacaoService,
		LocalidadeService	 $localidadeService,
		AvisoService		 $avisoService
	)
	{

		$this->userService          = $userService;
		$this->estadoService        = $estadoService;
		$this->cidadeService        = $cidadeService;
		$this->especialidadeService = $especialidadeService;
		$this->ramoService          = $ramoService;
		$this->comentarioService    = $comentarioService;
		$this->avaliacaoService     = $avaliacaoService;
		$this->localidadeService    = $localidadeService;
		$this->avisoService		    = $avisoService;
	}

	public function listarEstados()
	{
		$data = $this->estadoService->listarEstadosApi();

		return response()->json([

			'success' => true,
			'data'    => $data
		]);
	}

	public function listarCidades(Request $request)
	{
		$uf = $request->get('uf');

		if($uf)
		{
			$data = $this->cidadeService->listarCidadesApi($uf);
		}else
		{
			$data = [];
		}
		return response()->json([

			'success' => true,
			'data'    => $data
		]);

	}

	public function listarEspecialidades()
	{
		$data = $this->especialidadeService->listarEspecialidadesApi();

		return response()->json([

			'success' => true,
			'data'    => $data

		]);

	}

	public function listarRamos(Request $request)
	{
		$especialidade_id = $request->get('especialidade_id');

		if($especialidade_id)
		{
			$data = $this->ramoService->listarRamosApi($especialidade_id);
		}else
		{
			$data = [];
		}
		return response()->json([

			'success' => true,
			'data'    => $data
		]);
	}

	public function pesquisarProfissional(Request $request)
	{
		$data = $this->userService->pesquisar($request->all());

		return response()->json([

			'success' => true,
			'data'    => $data->toArray()
		]);
	}

	public function logarUsuario(Request $request)
	{
		$data = $this->userService->logarUsuarioApi( $request->all() );

		if($data)
		{
			$success = true;

		}else
		{
			$success = false;
			$data = [];

		}
		return response()->json([

			'success' => $success,
			'data'    => $data
		]);
	}

	public function registrarNovoUsuario(Request $request)
	{
		$data = $this->userService->registrarNovoUsuarioApi( $request->all() );

		if($data)
		{
			$success = true;

		}else
		{
			$success = false;
			$data = [];

		}
		return response()->json([

			'success' => $success,
			'data'    => $data
		]);
	}

	public function editarUsuario(Request $request)
	{
		$params = $request->all();

		try{
			$this->userService->editarUsuarioApi($params);
		}catch (Exception $ex){
		    $error = $ex->getMessage();
			return response()->json([
				'error' => $error
			]);
		}

		return response()->json([
			'message' => 'Perfil editado com sucesso'
		]);
	}

	public function getTotalComentarioProfissional(Request $request)
	{
		$data = $this->comentarioService->getTotalComentarioProfissional( $request->get('id') );

		if($data)
		{
			$success = true;

		}else
		{
			$success = false;
			$data = [];

		}
		return response()->json([

			'success' => $success,
			'data'    => $data
		]);

	}

	public function listarDadosProfissional(Request $request)
	{
		$data = $this->userService->listarDadosProfissionalApi( $request->get('id') );
		if($data)
		{
			$success = true;

		}else
		{
			$success = false;
			$data = [];

		}
		return response()->json([

			'success' => $success,
			'data'    => $data
		]);

	}

	public function listarComentariosProfissional(Request $request)
	{

		$data = $this->userService->listarComentariosProfissionalApi( $request->get('id') );

		if($data)
		{
			$success = true;

		}else
		{
			$success = false;
			$data = [];

		}
		return response()->json([

			'success' => $success,
			'data'    => $data
		]);

	}

	public function avaliarProfissional(Request $request)
	{
		$success = false;

		if($this->avaliacaoService->create($request->all()))
		{
			$success = true;
		}

		return response()->json([

			'success' => $success,


		]);
	}
	public function enviarComentario(Request $request)
	{
		$success = false;

		if($this->comentarioService->create($request->all()))
		{
			$success = true;
		}

		return response()->json([

			'success' => $success,


		]);
	}

	public function avisos(Request $request)
	{
		$avisos = $this->avisoService->listarAvisosByCliente($request->get('user_id'));
		$this->avisoService->atualizaViewByCliente($request->get('user_id'));

		return response()->json([
			'avisos' => $avisos
		]);
	}

	public function confirmar(Request $request)
	{
		$usuario      = $this->userService->find($request->get('user_id'));
		$profissional = $this->userService->find($request->get('profissional_id'));
		$localidade   = $this->localidadeService->find($request->get('localidade_id'));

		return response()->json([
			'usuario'      => $usuario,
			'profissional' => $profissional,
			'localidade'   => $localidade,
			'dia_agenda'   => $request->get('dia_agenda'),
			'horario_agenda' => $request->get('horario_agenda')
		]);
	}

	public function agendar($user_id, $localidade_id, Request $request)
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
		return response()->json([
			'user' => $user,
			'localidade' => $localidade,
			'dias_semanais' => $dias_semanais,
			'turnos' => $turnos,
			'semana_atual' => $semana_atual
		]);
	}

	public function buscaAvancada(Request $request)
	{
		$users = $this->userService->pesquisar($request->all())->toArray();

		return response()->json([
			'users' => $users
		]);
	}

}
