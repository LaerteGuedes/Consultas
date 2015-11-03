<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\AgendaRequest;
use App\Http\Controllers\Controller;

use App\Services\AgendaService;
use App\Services\LocalidadeService;
use App\Services\MessageService;


class AgendaController extends Controller
{
    protected $agendaService;
    protected $localidadeService;
    protected $consultaService;
    protected $messageService;



    public function __construct(AgendaService $agendaService,
                                LocalidadeService $localidadeService,
                                MessageService $messageService)
    {
        $this->agendaService     = $agendaService;
        $this->localidadeService = $localidadeService;
        $this->messageService    = $messageService;
    }


    public function index()
    {
        /*$agendas = $this->agendaService->paginateByUser(\Auth::user()->id);

        return view('agenda.index')->with([

           'agendas'      => $agendas


        ]);*/

        return $this->novo();
    }

    public function novo()
    {
        $localidades = $this->localidadeService->listForComboByUser(\Auth::user()->id);
        $horas       = $this->agendaService->getHoras();
        $intervalos  = $this->agendaService->getIntervalos();
        $eventos     = $this->agendaService->listForCalendarByUser(\Auth::user()->id);

        if($eventos)
        {
            $event = json_encode($eventos);
        }else{
            $event = json_encode([]);
        }

        return view('agenda.novo')->with([

            'localidades' => $localidades,
            'horas'       => $horas,
            'intervalos'  => $intervalos,
            'eventos'     => $event

        ]);
    }

    public function store(Request $request)
    {

        if(!$request->get('localidade_id') || empty($request->get('localidade_id')) ){
                return \Response::json(['success'=> false , 'message'=> 'A localidade é um campo obrigatório!' ]);
        }

        $success = false;
        $event   = [];
        $data = array_add($request->all() ,'user_id' , \Auth::user()->id);


        if(!$this->agendaService->checkIfExists($data))
        {

            if($this->agendaService->create($data))
            {
                $success = true;
                $event = $this->agendaService->listForCalendarByUser(\Auth::user()->id);
            }

            return \Response::json(['success'=>$success , 'events'=> json_encode($event) ]);

        }else
        {
            return \Response::json(['success'=>$success , 'message'=> 'Não foi possível registrar, agendamento já existente!' ]);
        }


    }

    public function edit($id)
    {
        $localidades = $this->localidadeService->listForComboByUser(\Auth::user()->id);
        $horas       = $this->agendaService->getHoras();
        $intervalos  = $this->agendaService->getIntervalos();

        $agenda      = $this->agendaService->find($id);

        return view('agenda.edit')->with([

            'localidades' => $localidades,
            'horas'       => $horas,
            'intervalos'  => $intervalos,
            'agenda'      => $agenda

        ]);
    }

    public function update($id , AgendaRequest $request)
    {
        $data = $request->all();
        $data['data_agenda'] = $this->agendaService->convertDateForDataBase($data['data_agenda']);
        $data['horario_agenda'] = $this->agendaService->joinHoraMin($data['horas'],$data['minutos']);
        $data['user_id'] = \Auth::user()->id;

        if($this->agendaService->checkIfBusy($id))
        {
            return redirect()->route('edit.agenda',$id)->withErrors(['Não foi possível realizar a operação! Os dados já estão sendo utilizados pelo sistema.']);
        }

        if(!$this->agendaService->checkIfExists($data))
        {

            if($this->agendaService->update($id , $data))
            {
                return redirect()->route('agenda')->with(['message'=> $this->messageService->getMessage('success')]);

            }else{

                return redirect()->route('edit.agenda',$id)->withErrors([$this->messageService->getMessage('error')]);
            }

        }else
        {
            return redirect()->route('edit.agenda',$id)->withErrors(['Não foi possível realizar a operação! Os dados  alterados coincidem com um agendamento já existente.']);
        }
    }

    public function delete($id)
    {
        if(!$this->agendaService->checkIfBusy($id))
        {
            if($this->agendaService->destroy($id))
            {
                return redirect()->route('agenda')->with(['message'=> $this->messageService->getMessage('success')]);
            }else{
                return redirect()->route('agenda')->withErrors([$this->messageService->getMessage('error')]);

            }
        }else{
            return redirect()->route('agenda')->withErrors(['Não foi possível excluir o registro! Os dados estão sendo utilizados pelo sistema.']);

        }
    }

}
