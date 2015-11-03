<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;


use App\Services\RamoService;
use App\Services\UserRamoService;
use App\Services\MessageService;

use App\Http\Requests\RamoRequest;

class RamoController extends Controller
{
    protected $ramoService;
    protected $userRamoService;
    protected $messageService;

    public function __construct(RamoService $ramoService ,
                                UserRamoService $userRamoService ,
                                MessageService $messageService)
    {
        $this->ramoService = $ramoService;
        $this->messageService   = $messageService;
        $this->userRamoService = $userRamoService;
    }

    public function index()
    {


        $ramos = $this->userRamoService->paginateByUser(\Auth::user()->id);
        return view('ramo.index')->with('ramos',$ramos);
    }
    public function novo()
    {
        return view('ramo.novo');
    }
    public function store(RamoRequest $request)
    {
        if(!$request->get('check_ramo_id')) {

            $data  = array_add($request->all(), 'especialidade_id', \Auth::user()->especialidade->especialidade_id);
            $ramo  = $this->ramoService->create($data);

            if($ramo)
            {
                if($this->userRamoService->create(['ramo_id'=> $ramo->id , 'user_id' => \Auth::user()->id ]))
                {
                    return redirect()->route('ramos')->with('message',$this->messageService->getMessage('success'));

                }
            }

            return redirect()->route('novo.ramo')->withErros([$this->messageService->getMessage('error')]);

        }else{

            if($this->userRamoService->create(['ramo_id'=> $request->get('check_ramo_id') , 'user_id' => \Auth::user()->id ]))
            {
                return redirect()->route('ramos')->with('message',$this->messageService->getMessage('success'));

            }

            return redirect()->route('novo.ramo')->withErros([$this->messageService->getMessage('error')]);
        }

    }
    public function edit($id)
    {

        $ramo = $this->ramoService->find($id);

        return view('ramo.edit')->with('ramo',$ramo);


    }
    public function update($id  , RamoRequest $request )
    {

        $data = array_add( $request->all() , 'user_id' , \Auth::user()->id );

        if($this->ramoService->update($id ,$data))
        {
            return redirect()->route('ramos')->with('message',$this->messageService->getMessage('success'));
        }

        return redirect()->route('edit.ramo' , $id )->withErros([$this->messageService->getMessage('error')]);

    }
    public function delete($id)
    {
        if ($this->userRamoService->destroy($id)) {
            return redirect()->route('ramos')->with('message', $this->messageService->getMessage('success'));
        }

        return redirect()->route('ramos')->withErros([$this->messageService->getMessage('error')]);

    }

    public function all($especialidade_id = null)
    {
        if(null == $especialidade_id)
        {
            foreach($this->ramoService->all(['id','nome']) as $item)
            {
                $data[]=['id'=> $item['id'] , 'name'=> $item['nome']];
            }

        }else
        {
            $data =  $this->ramoService->listarRamoByEspecialidade($especialidade_id);
        }


        return \Response::json(['data' => $data]);
    }
}
