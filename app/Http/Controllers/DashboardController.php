<?php

namespace App\Http\Controllers;

use App\Custom\Debug;
use App\Services\CidadeService;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;


use App\Services\EstadoService;
use App\Services\UserService;
use App\Services\EspecialidadeService;
use App\Services\ConsultaService;
use App\Services\AvaliacaoService;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

	protected $estadoService;
	protected $userService;
	protected $especialidadeService;
	protected $avaliacaoService;
	protected $cidadeService;

	public function __construct(EstadoService $estadoService,
								UserService $userService,
								EspecialidadeService $especialidadeService,
								ConsultaService $consultaService,
								AvaliacaoService $avaliacaoService,
								CidadeService $cidadeService)
	{
		$this->estadoService = $estadoService;
		$this->cidadeService = $cidadeService;
		$this->userService   = $userService;
		$this->especialidadeService = $especialidadeService;
		$this->consultaService = $consultaService;
		$this->avaliacaoService = $avaliacaoService;
	}

    public function index()
    {
    	$estados = array("PA" => "PA");
		$cidades = $this->cidadeService->listCidadesAreaMetropolitanaBelem();
    	$especialidades = $this->especialidadeService->listCombo();
    	$totalConsultasFuturas = $this->consultaService->getTotalConsultasFuturasByUser( \Auth::user()->id );
    	$totalAvaliacao =  $this->avaliacaoService->getAvaliacaoProfissional( \Auth::user()->id );

        return view('dashboard.index')->with([
        		'estados' => $estados,
				'cidades' => $cidades,
        		'especialidades' => $especialidades,
        		'total_consultas' => $totalConsultasFuturas,
        		'total_avaliacao'  => $totalAvaliacao
        	]);
    }
}
