<?php

namespace App\Http\Controllers;

use App\Custom\Debug;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Services\ConsultaService;
use App\Services\CalendarService;

class ConsultaController extends Controller
{
    protected $consultaService;
    protected $calendarService;

    public function __construct(ConsultaService $consultaService,
    							CalendarService $calendarService)
    {
        $this->consultaService = $consultaService;
        $this->calendarService = $calendarService;
    }

    public function index(Request $request)
    {
    	if(\Auth::user()->role->name == 'Cliente')
    	{
    		$futuras    = $this->consultaService->listarConsultasFuturasByUser(\Auth::user()->id);
    		$historicos = $this->consultaService->listarConsultasHistoricoByUser(\Auth::user()->id);


		       return view('consulta.index')->with([

		       		'futuras'    => $futuras,
		       		'historicos' => $historicos

		       	]);
		}else
		{	
			if($request->get('next_mes'))	
			{
				$mes = $request->get('next_mes');
				
			}elseif($request->get('previous_mes'))
			{
				$mes = $request->get('previous_mes');

			}else
			{
				$mes = $this->calendarService->getMesAtual();
			}

			$next_mes = $this->calendarService->getNextMes($mes);
			$previous_mes = $this->calendarService->getPreviousMes($mes);	

			$consultas = $this->consultaService->listarConsultasByProfissional(\Auth::user()->id ,[

						'mes' => date('m', strtotime($mes)),
						'ano' => date('Y', strtotime($mes))

				]);

			return view('consulta.index')->with([
						'mes'=>$mes,
						'next_mes'=> $next_mes,
						'previous_mes' => $previous_mes,
						'consultas' => $consultas
					]);
		}
    }

    public function confirmar(Request $request)
    {
    	$response = $this->consultaService->confirmarConsulta($request->all());

    	return response()->json(['success'=> $response ]);
    }

    public function realizar(Request $request)
    {
    	$response = $this->consultaService->realizarConsulta($request->all());

    	return response()->json(['success'=> $response ]);
    }


}
