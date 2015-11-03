<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\CurriculoRequest;
use App\Services\CurriculoService;
use App\Services\MessageService;

class CurriculoController extends Controller
{

    protected $curriculoService;
    protected $messageService;

    public function __construct(CurriculoService $curriculoService , MessageService $messageService)
    {
            $this->curriculoService = $curriculoService;
            $this->messageService   = $messageService;
    }

    public function index()
    {
        $curriculos = $this->curriculoService->paginateByUser(\Auth::user()->id );
        return view('curriculo.index')->with('curriculos',$curriculos);
    }
    public function novo()
    {
        return view('curriculo.novo');
    }
    public function store(CurriculoRequest $request)
    {
        $data = array_add( $request->all() , 'user_id' , \Auth::user()->id );

        if($this->curriculoService->create($data))
        {
            return redirect()->route('curriculos')->with('message',$this->messageService->getMessage('success'));
        }

        return redirect()->route('novo.curriculo')->withErros([$this->messageService->getMessage('error')]);

    }
    public function edit($id)
    {

        $curriculo = $this->curriculoService->find($id);

        return view('curriculo.edit')->with('curriculo',$curriculo);


    }
    public function update($id  , CurriculoRequest $request )
    {

        $data = array_add( $request->all() , 'user_id' , \Auth::user()->id );

        if($this->curriculoService->update($id ,$data))
        {
            return redirect()->route('curriculos')->with('message',$this->messageService->getMessage('success'));
        }

        return redirect()->route('edit.curriculo' , $id )->withErros([$this->messageService->getMessage('error')]);

    }
    public function delete($id)
    {
        if ($this->curriculoService->destroy($id)) {
            return redirect()->route('curriculos')->with('message', $this->messageService->getMessage('success'));
        }

        return redirect()->route('curriculos')->withErros([$this->messageService->getMessage('error')]);

    }

}
