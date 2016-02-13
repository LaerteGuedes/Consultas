<?php

namespace App\Http\Controllers;

use App\Custom\Debug;
use App\Services\PlanoService;
use App\Services\UserService;


use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;

class UserPlanoController extends Controller
{
    protected $planoService;
    protected $userService;

    public function __construct(PlanoService $planoService, UserService $userService)
    {
        $this->planoService = $planoService;
        $this->userService = $userService;
    }

    public function index()
    {
        $planos = $this->planoService->paginateByUser(Auth::user()->id);

        return view("plano.index")->with("planos", $planos);
    }

    public function novo()
    {
        $planosPai = $this->planoService->findParents();
        $planosPaiExistentes = $this->planoService->findParentsById(Auth::user()->id);
        $planosFilho = $this->planoService->findAllChildrenCheckbox();
        $planosFilhoExistentes = $this->planoService->paginateByUser(Auth::user()->id);
        $vPlanosPais = array();

        foreach ($planosPai as $key => $planoPai){
            $vPlanos[$planoPai->id] = $planoPai->toArray();
            if (sizeof($planosPaiExistentes)){
                foreach ($planosPaiExistentes as $planoPaiExistente){
                    if ($planoPai->id == $planoPaiExistente->id){
                        $vPlanos[$planoPai->id] = ['checked' => 'checked', 'titulo' => $planoPai->titulo];
                        break;
                    }else{
                        $vPlanos[$planoPai->id] = ['checked' => '', 'titulo' => $planoPai->titulo];
                    }
                }
            }
        }

        if (sizeof($planosPaiExistentes)){
            foreach ($vPlanos as $id => $plano){
                if ($vPlanos[$id]['checked'] == 'checked'){
                    $vPlanos[$id]['filhos'] = $this->planoService->findChildren($id)->toArray();
                }
            }
        }

        foreach ($vPlanos as $key => $plano){
            if (isset($plano['filhos'])){
                foreach ($plano['filhos'] as $keyFilho => $planoFilho){
                    if(sizeof($planosFilhoExistentes)){
                        foreach ($planosFilhoExistentes as $planoFilhoExistente){
                            if ($planoFilho['id'] == $planoFilhoExistente->id){
                                $vPlanos[$key]['filhos'][$keyFilho] = ['checked' => 'checked', 'titulo' => $planoFilhoExistente->titulo, 'id' => $planoFilho['id']];
                                break;
                            }else{
                                $vPlanos[$key]['filhos'][$keyFilho] = ['checked' => '', 'titulo' => $planoFilho['titulo'], 'id' => $planoFilho['id']];
                            }
                        }
                    }
                }
            }
        }

        return view("plano.novo")->with('planos', $planosPai)->with('vPlanos', $vPlanos);
    }

    public function salvar(){
        $planos = Request::input('planos');

        if (Request::has('nao_atende_planos')){
            if (Request::input('nao_atende_planos')){
                $this->userService->userNaoAtendePlanos(Auth::user()->id);
                return Redirect::to("/planos")->with("message", "Atualizado com sucesso!");
            }
        }

        $isSaved = $this->planoService->insertUserPlanos(Auth::user()->id, $planos);

        if ($isSaved){
            return Redirect::to("/planos")->with("message", "Planos atualizados com sucesso!");
        }


        return Redirect::to('/planos')->with('errors', "Houve um problema com a inserção. Tente novamente mais tarde");
    }

    public function ajaxplano(){
        $planoPai = $this->planoService->find(Request::input('id'));
        $planos = $planoPai->children;

        $response = ['planoPai' => $planoPai, 'planos' => $planos];

        return response()->json($response);
    }

    public function ajaxPlanoCliente()
    {
        $planoPai = $this->planoService->find(Request::input('id'));
        $planos = $planoPai->children;

        $response = ['planoPai' => $planoPai, 'planos' => $planos];

        return response()->json($response);
    }

    public function delete(){
        $id = Request::input('id');
        $this->userService->deleteplano(Auth::user()->id,$id);

        return Redirect::to('/planos')->with("message", "Plano deletado com sucesso!");
    }
}
