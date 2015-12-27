<?php

namespace App\Http\Controllers;

use App\Custom\Debug;
use App\Services\AvisoService;
use App\Services\CalendarService;
use App\Services\GradeService;
use App\Services\LocalidadeService;
use Illuminate\Database\Eloquent\Collection;
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
	protected $gradeService;
	protected $calendarService;

	public function __construct(

		UserService          $userService,
		EstadoService        $estadoService,
		CidadeService        $cidadeService,
		EspecialidadeService $especialidadeService,
		RamoService          $ramoService,
		ComentarioService    $comentarioService,
		AvaliacaoService     $avaliacaoService,
		LocalidadeService	 $localidadeService,
		AvisoService		 $avisoService,
		GradeService		 $gradeService,
		CalendarService		 $calendarService
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
		$this->gradeService			= $gradeService;
		$this->calendarService		= $calendarService;
	}

	public function listarEstados()
	{
		$data = $this->estadoService->listarEstadosApi();

		return response()->json([

			'success' => true,
			'data'    => $data
		]);
	}

    public function listarLocalidades(Request $request){
        $localidades = $this->localidadeService->findBy('user_id', $request->get('id'));
        return response()->json(['localidades' => $localidades]);
    }

	public function localidadeDetalhe($id){
		$localidade = $this->localidadeService->find($id);
	    return response()->json(['localidade' => $localidade]);
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

    public function usuarioDetalhe(Request $request){
        $user = $this->userService->find($request->get('id'));
        return response()->json($user);
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

        foreach ($semana_atual as $key => $dia) {
            $semana_atual[$key] = ['dia' => $dia, 'diaF' => date('d/m',strtotime($dia))];
        }

		$grade = array();

		foreach ($semana_atual as $dia_semana => $dia) {
			$aux = array();
			$aux['dia_semana'] = $dia_semana;
			$aux['dia'] = $dia;

			foreach($turnos as $sigla_turno => $turno){

				$horarios = $this->gradeService->getHorariosAtualPorLocalidadeByUser($user->id, $localidade->id, $dia_semana, $dia['dia'], $sigla_turno);
				$aux['turnos'][$turno]['horarios'] = $horarios;
			}

			$grade[] = $aux;
		}

        $primeiroDiaDaSemana = $semana_atual['seg'];


        return response()->json([
			'user' => $user,
			'localidade' => $localidade,
			'dias_semanais' => $dias_semanais,
			'turnos' => $turnos,
			'semana_atual' => $semana_atual,
			'grade' => $grade,
            'primeiroDiaDaSemana' => $primeiroDiaDaSemana
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
