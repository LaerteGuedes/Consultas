<?php

namespace App\Http\Controllers;

use App\Custom\Debug;
use App\Services\CidadeService;
use App\Services\MailService;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Services\ConsultaService;
use App\Services\CalendarService;
use Illuminate\Support\Facades\Auth;

class ConsultaController extends Controller
{
    protected $consultaService;
    protected $calendarService;
    protected $cidadeService;
    protected $mailService;

    public function __construct(ConsultaService $consultaService,
                                CalendarService $calendarService,
                                CidadeService $cidadeService,
                                MailService $mailService)
    {
        $this->consultaService = $consultaService;
        $this->calendarService = $calendarService;
        $this->cidadeService = $cidadeService;
        $this->mailService = $mailService;
    }

    public function index(Request $request)
    {
        if(\Auth::user()->role->name == 'Cliente')
        {
            $futuras    = $this->consultaService->listarConsultasFuturasByUser(\Auth::user()->id);
            $historicos = $this->consultaService->listarConsultasHistoricoByUser(\Auth::user()->id);
            $cidades = $this->cidadeService->listCidadesAreaMetropolitanaBelemList();

            return view('consulta.index')->with([
                'futuras'    => $futuras,
                'historicos' => $historicos,
                'cidades'    => $cidades
            ]);
        }else{
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
            $cidades = $this->cidadeService->listCidadesAreaMetropolitanaBelemList();

            $consultas = $this->consultaService->listarConsultasByProfissional(\Auth::user()->id ,[

                'mes' => date('m', strtotime($mes)),
                'ano' => date('Y', strtotime($mes))

            ]);

            return view('consulta.index')->with([
                'mes'=>$mes,
                'next_mes'=> $next_mes,
                'previous_mes' => $previous_mes,
                'consultas' => $consultas,
            ]);
        }
    }

    public function confirmar(Request $request)
    {
        $user = Auth::user();

        $consulta = $this->consultaService->find($request->get('consulta_id'));
        if ($request->resposta == 'nao'){
            $response = $this->consultaService->cancelarConsulta($consulta, $this->mailService, Auth::user());
        }else{
            $response = $this->consultaService->confirmarConsulta($request->all());
        }

        return response()->json(['success'=> $response ]);
    }

    public function realizar(Request $request)
    {
        $response = $this->consultaService->realizarConsulta($request->all());

        return response()->json(['success'=> $response ]);
    }

    public function noShow(Request $request)
    {
        $response = $this->consultaService->noShow($request->all());

        return response()->json(['success'=> $response ]);
    }


}
