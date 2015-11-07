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
        $planos = $this->planoService->findParents();
        $planosExistentes = $this->planoService->paginateByUser(Auth::user()->id);
        $planosPai = array();

        foreach($planosExistentes as $plano){

            $planosPai[$plano->parent->id] = $plano->parent->titulo;
        }

        return view("plano.novo")->with('planos', $planos);
    }

    public function salvar(){
        $planos = Request::input('planos');

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

    public function delete(){
        $id = Request::input('id');
        $this->userService->deleteplano(Auth::user()->id,$id);

        return Redirect::to('/planos')->with("message", "Plano deletado com sucesso!");
    }
}
