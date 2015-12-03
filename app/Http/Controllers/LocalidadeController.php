<?php

namespace App\Http\Controllers;

use App\Custom\Debug;
use Illuminate\Http\Request;

use App\Http\Requests\LocalidadeRequest;
use App\Http\Controllers\Controller;

use App\Services\LocalidadeService;
use App\Services\MessageService;
use App\Services\EstadoService;
use App\Services\CidadeService;
use App\Services\BairroService;

class LocalidadeController extends Controller
{
    protected $localidadeService;
    protected $messageService;
    protected $estadoService;
    protected $cidadeService;

    public function __construct(LocalidadeService $localidadeService, MessageService $messageService,
                                EstadoService $estadoService, CidadeService $cidadeService)
    {
        $this->localidadeService = $localidadeService;
        $this->messageService = $messageService;
        $this->estadoService = $estadoService;
        $this->cidadeService = $cidadeService;
    }


    public function index()
    {
        $localidades = $this->localidadeService->paginateByUser(\Auth::user()->id );

        return view('localidade.index')->with('localidades',$localidades);
    }
    public function novo(EstadoService $estadoService, CidadeService $cidadeService)
    {
        $estados = array('PA' => 'PA');
        $cidades = $cidadeService->listCidadesAreaMetropolitanaBelem();
        $tipos   = $this->localidadeService->getTipos();

        return view('localidade.novo')->with([
                'estados' => $estados,
                'cidades_belem' => $cidades,
                'tipos'   => $tipos
        ]);
    }
    public function store(LocalidadeRequest $request , BairroService $bairroService)
    {
        $data = array_add( $request->all() , 'user_id' , \Auth::user()->id );

        if(!$request->get('bairro_id'))
        {
            $bairro    = $bairroService->create([

                'cidade_id' => $request->get('cidade_id'),
                'nome'      => $request->get('bairro')

            ]);

            if($bairro)
            {
                $data = array_add( $data , 'bairro_id' , $bairro->id );
            }

        }

        if($this->localidadeService->create($data))
        {
           if($data['tipo']=='DOMICILIO')
           {

            return redirect()->route('novo.localidade')->with('message',$this->messageService->getMessage('success'));

           }else
           {
             return redirect()->route('grade')->with('message',$this->messageService->getMessage('success'));
           }
        }



        return redirect()->route('novo.localidade')->withErros([$this->messageService->getMessage('error')]);

    }
    public function edit($id , EstadoService $estadoService , CidadeService $cidadeService, BairroService $bairroService)
    {
        $localidade = $this->localidadeService->find($id);
        $estados = array('PA');
        $cidades =$cidadeService->listCidadesAreaMetropolitanaBelem();
        $tipos   = $this->localidadeService->getTipos();


        return view('localidade.edit')->with([

            'estados' => $estados,
            'cidades' => $cidades,
            'tipos'   => $tipos,
            'localidade' => $localidade,

        ]);


    }
    public function update($id  , LocalidadeRequest $request , BairroService $bairroService )
    {

        $data = array_add( $request->all() , 'user_id' , \Auth::user()->id );

        if(!$request->get('bairro_id') || $request->get('bairro_id') == "")
        {
            $bairro    = $bairroService->create([

                'cidade_id' => $request->get('cidade_id'),
                'nome'      => $request->get('bairro')

            ]);

            if($bairro)
            {
                $data['bairro_id'] =  $bairro->id;
            }

        }

        if($this->localidadeService->update($id ,$data))
        {
            return redirect()->route('localidades')->with('message',$this->messageService->getMessage('success'));
        }

        return redirect()->route('edit.localidade' , $id )->withErros([$this->messageService->getMessage('error')]);

    }
    
    public function delete($id)
    {
        if($this->localidadeService->destroy($id))
        {
            return redirect()->route('localidades')->with('message',$this->messageService->getMessage('success'));
        }

        return redirect()->route('localidades' )->withErros([$this->messageService->getMessage('error')]);

    }

    public function deleteFromGrade($id)
    {
        if($this->localidadeService->destroy($id))
        {
            return redirect()->route('grade')->with('message',$this->messageService->getMessage('success'));
        }

        return redirect()->route('grade' )->withErros([$this->messageService->getMessage('error')]);

    }

    public function listCidades($uf , CidadeService $cidadeService)
    {
            return \Response::json( ['data' => $cidadeService->listCidadesByUf($uf) ] );
    }

    public function listBairros($cidade_id, BairroService $bairroService)
    {
        $data = [];
        $res = $bairroService->listBairroByCidade($cidade_id);
        if($res)
        {
            foreach($res as $item)
            {
                $data[] = [
                    'id'  => $item['id'],
                    'name'=> $item['nome']
                ];
            }
        }
        return \Response::json( ['data' => $data ] );
    }
}
