<?php

namespace App\Http\Controllers;

use App\Custom\Debug;
use App\Services\MessageService;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\GradeService;
use App\Services\LocalidadeService;
use Illuminate\Support\Facades\Auth;

class GradeController extends Controller
{
    protected $gradeService;
    protected $localidadeService;
	protected $messageService;

    public function __construct(GradeService $gradeService,
    							LocalidadeService $localidadeService,
								MessageService $messageService)
    {
    	$this->gradeService      = $gradeService;
    	$this->localidadeService = $localidadeService;
		$this->messageService = $messageService;
    }

    public function index()
    {
    	$localidades   = $this->localidadeService->listForComboByUser(\Auth::user()->id);
    	$dias_semanais = $this->gradeService->getDiasSemanais();
    	$turnos        = $this->gradeService->getTurnos();
		$horasManha = $this->gradeService->getHoras(6, 12);
		$horasTarde = $this->gradeService->getHoras(12, 18);
		$horasNoite = $this->gradeService->getHoras(18, 23);
    	$intervalos    = $this->gradeService->getIntervalos();
		$intervalos_abreviados    = $this->gradeService->getIntervalosAbreviados();

    	return view('grade.index')->with([
    			'localidades'   => $localidades,
    			'turnos'        => $turnos,
    			'dias_semanais' => $dias_semanais,
    			'gradeService'  => $this->gradeService,
    			'horasManha'    => $horasManha,
			    'horasTarde'    => $horasTarde,
			    'horasNoite'    => $horasNoite,
    			'intervalos'    => $intervalos,
    			'intervalos_abreviados' => $intervalos_abreviados
    		]);
    }

    public function store(Request $request)
    {
    	$response = $this->gradeService->save(\Auth::user()->id,$request->all());
        if (is_array($response)){
            $message = 'O horário '.$response['horario'].' está incompatível com outros horários que você possui.';
            return \Response::json(['message'=> $message]);
        }
    	return \Response::json(['data'=> $response]);
    }

    public function deleteHorario($id)
    {
    	if( $this->gradeService->destroy($id) )
    	{
    		return redirect()->route('grade')->with(['message'=> 'registro apagado com sucesso!']);
    	}
    }

	public function deleteHorarioAjax($id)
	{
		if( $this->gradeService->destroy($id) )
		{
			return response()->json(['success' => true]);
		}else{
            return response()->json(['success' => false]);
        }
	}

	public function etapaAtual(Request $request)
	{
		
	}

	public function cancelarDia($localidade_id, $dia_semana)
	{
		$teste = $this->gradeService->cancelarDia(Auth::user()->id, $localidade_id, $dia_semana);
		return redirect()->to('grade')->with('message', $this->messageService->getMessage('success'));
	}
}
