<?php

namespace App\Http\Controllers;

use App\Custom\Debug;
use App\Services\CidadeService;
use App\Services\EspecialidadeService;
use App\Services\EstadoService;
use App\Services\MessageService;
use App\Services\PlanoService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AdmController extends Controller
{
    protected $userService;
    protected $planoService;
    protected $especialidadeService;
    protected $estadoService;
    protected $cidadeService;
    protected $messageService;

    public function __construct(UserService $userService,
                                PlanoService $planoService,
                                EspecialidadeService $especialidadeService,
                                EstadoService $estadoService,
                                CidadeService $cidadeService,
                                MessageService $messageService)
    {
        $this->userService = $userService;
        $this->planoService = $planoService;
        $this->especialidadeService = $especialidadeService;
        $this->estadoService = $estadoService;
        $this->cidadeService = $cidadeService;
        $this->messageService = $messageService;
    }

    public function dashboard()
    {
        return view("adm.dashboard");
    }

    public function usuarios(){
        $usuarios = $this->userService->all();
        
        //return view("adm.usuarios")->with('usuarios', $usuarios);
        return response()->json(['usuarios' => $usuarios]);
    }

    public function deleteusuario($user_id){
        $this->userService->destroy($user_id);

        return redirect()->route("adm.usuarios")->with("message", $this->messageService->getMessage('success'));
    }
    
    public function operadoras(){
        $planos = $this->planoService->findParents();

        return view("adm.operadoras")->with("planos", $planos);
    }

    public function planos(){
        $planos = $this->planoService->all();

        return view("adm.planos")->with('planos', $planos);
    }

    public function novoplano(){
        return view("adm.novaoperadora");
    }
    
    public function salvaplano(Request $request){
        $this->planoService->create($request->all());

        return redirect()->route("adm.planos")->with("message", $this->messageService->getMessage('success'));
    }
    
    public function editplano($id){
        $plano = $this->planoService->find($id);
        return view("adm.editplano")->with('plano', $plano);
    }   
    
    public function updateplano(Request $request){
        $params = array();

        foreach ($request->all() as $field => $param) {
            $params[$field] = $param;
        }
        unset($params['id']);

        $idPlano = $this->planoService->update($request->get('id'), $params);

        return response()->json(['idPlano' => $idPlano]);
    }
    
}