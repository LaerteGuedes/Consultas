<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\GradeService;
use App\Services\LocalidadeService;

class GradeController extends Controller
{
    protected $gradeService;
    protected $localidadeService;

    public function __construct(GradeService $gradeService,
    							LocalidadeService $localidadeService)
    {
    	$this->gradeService      = $gradeService;
    	$this->localidadeService = $localidadeService;
    }

    public function index()
    {

    	$localidades   = $this->localidadeService->listForComboByUser(\Auth::user()->id);
    	$dias_semanais = $this->gradeService->getDiasSemanais();
    	$turnos        = $this->gradeService->getTurnos();
    	$horas         = $this->gradeService->getHoras();
    	$intervalos    = $this->gradeService->getIntervalos();
		$intervalos_abreviados    = $this->gradeService->getIntervalosAbreviados();

    	return view('grade.index')->with([

    			'localidades'   => $localidades,
    			'turnos'        => $turnos,
    			'dias_semanais' => $dias_semanais,
    			'gradeService'  => $this->gradeService,
    			'horas'         => $horas,
    			'intervalos'    => $intervalos,
    			'intervalos_abreviados' => $intervalos_abreviados
 
    		]);
    }

    public function store(Request $request)
    {

    	$response = $this->gradeService->save(\Auth::user()->id,$request->all());
    	return \Response::json(['data'=> $response ]);
    }

    public function deleteHorario($id)
    {
    	if( $this->gradeService->destroy($id) )
    	{
    		return redirect()->route('grade')->with(['message'=> 'registro apagado com sucesso!']);
    	}
    }
}
