<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;


use App\Services\EstadoService;
use App\Services\UserService;
use App\Services\EspecialidadeService;
use App\Services\ConsultaService;
use App\Services\AvaliacaoService;

class DashboardController extends Controller
{

	protected $estadoService;
	protected $userService;
	protected $especialidadeService;
	protected $avaliacaoService;

	public function __construct(EstadoService $estadoService,
								UserService $userService,
								EspecialidadeService $especialidadeService,
								ConsultaService $consultaService,
								AvaliacaoService $avaliacaoService)
	{
		$this->estadoService = $estadoService;
		$this->userService   = $userService;
		$this->especialidadeService = $especialidadeService;
		$this->consultaService = $consultaService;
		$this->avaliacaoService = $avaliacaoService;
	}

    public function index()
    {

    	$estados = $this->estadoService->listCombo();
    	$especialidades = $this->especialidadeService->listCombo();
    	$totalConsultasFuturas = $this->consultaService->getTotalConsultasFuturasByUser( \Auth::user()->id );
    	$totalAvaliacao =  $this->avaliacaoService->getAvaliacaoProfissional( \Auth::user()->id );

        return view('dashboard.index')->with([

        		'estados' => $estados,
        		'especialidades' => $especialidades,
        		'total_consultas' => $totalConsultasFuturas,
        		'total_avaliacao'  => $totalAvaliacao


        	]);
    }
}
