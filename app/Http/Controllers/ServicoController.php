<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\ServicoRequest;

use App\Services\ServicoService;
use App\Services\MessageService;

class ServicoController extends Controller
{
    protected $servicoService;
    protected $messageService;

    public function __construct(servicoService $servicoService , MessageService $messageService)
    {
        $this->servicoService = $servicoService;
        $this->messageService   = $messageService;

    }

    public function index()
    {
        $servicos = $this->servicoService->paginateByUser(\Auth::user()->id);

        return view('servico.index')->with('servicos',$servicos);
    }
    public function novo()
    {
        return view('servico.novo');
    }
    public function store(ServicoRequest $request)
    {
        $data = array_add( $request->all() , 'user_id' , \Auth::user()->id );

        if($this->servicoService->create($data))
        {
            return redirect()->route('servicos')->with('message',$this->messageService->getMessage('success'));
        }

        return redirect()->route('novo.servico')->withErros([$this->messageService->getMessage('error')]);

    }
    public function edit($id)
    {

        $servico = $this->servicoService->find($id);

        return view('servico.edit')->with('servico',$servico);


    }
    public function update($id  , ServicoRequest $request )
    {

        $data = array_add( $request->all() , 'user_id' , \Auth::user()->id );

        if($this->servicoService->update($id ,$data))
        {
            return redirect()->route('servicos')->with('message',$this->messageService->getMessage('success'));
        }

        return redirect()->route('edit.servico' , $id )->withErros([$this->messageService->getMessage('error')]);

    }
    public function delete($id)
    {
        if($this->servicoService->destroy($id))
        {
            return redirect()->route('servicos')->with('message',$this->messageService->getMessage('success'));
        }

        return redirect()->route('servicos' )->withErros([$this->messageService->getMessage('error')]);

    }
}
