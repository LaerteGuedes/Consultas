<?php

namespace App\Http\Controllers;

use App\Avaliacao;
use App\Custom\Debug;
use App\Http\Requests\UpdatePerfilRequest;
use App\Role;
use App\Services\AvaliacaoService;
use App\Services\CidadeService;
use App\Services\ConsultaService;
use App\Services\EspecialidadeService;
use App\Services\EstadoService;
use App\Services\MessageService;
use App\Services\PlanoService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class AdmController extends Controller
{
    protected $userService;
    protected $planoService;
    protected $especialidadeService;
    protected $estadoService;
    protected $cidadeService;
    protected $messageService;
    protected $consultaService;
    protected $avaliacaoService;

    public function __construct(UserService $userService,
                                PlanoService $planoService,
                                EspecialidadeService $especialidadeService,
                                EstadoService $estadoService,
                                CidadeService $cidadeService,
                                MessageService $messageService,
                                ConsultaService $consultaService,
                                AvaliacaoService $avaliacaoService)
    {
        $this->userService = $userService;
        $this->planoService = $planoService;
        $this->especialidadeService = $especialidadeService;
        $this->estadoService = $estadoService;
        $this->cidadeService = $cidadeService;
        $this->messageService = $messageService;
        $this->consultaService = $consultaService;
        $this->avaliacaoService = $avaliacaoService;
    }

    public function login(){
        return view("adm.login.index");
    }

    public function auth(Request $request){
        $user = $this->userService->getByEmail($request->get('email'));
        if (!(isset($user->id) && $user->role_id == Role::ADMINISTRADOR)){
            return redirect()->route("adm.login")->with('message', 'Login incorreto! Tente novamente');
        }

        if (Auth::attempt(['email' => $request->get('email'), 'password' => $request->get('password')])){
            return redirect()->route("adm.dashboard")->with('message', $this->messageService->getMessage('success'));
        }
    }

    public function dashboard()
    {
        $totalUsuarios = $this->userService->total();
        $totalAgendadas = $this->consultaService->countAgendadas();
        $totalRealizadas = $this->consultaService->countRealizadas();
        $totalCanceladas = $this->consultaService->countCanceladas();
        $totalAvaliacoes = $this->avaliacaoService->total();
        $totalProfissionais = $this->userService->totalProfissional();
        $totalProfissionaisAtivos = $this->userService->totalProfissionalAtivo();
        $totalProfissionaisInativos = $this->userService->totalProfissionalInativo();

        return view("adm.dashboard")->with(['totalUsuarios' => $totalUsuarios,
            'totalAgendadas' => $totalAgendadas,
            'totalRealizadas' => $totalRealizadas,
            'totalCanceladas' => $totalCanceladas,
            'totalAvaliacoes' => $totalAvaliacoes,
            'totalProfissionais' => $totalProfissionais,
            'totalProfissionaisAtivos' => $totalProfissionaisAtivos,
            'totalProfissionaisInativos' => $totalProfissionaisInativos]);
    }

    public function usuarios(Request $request){
        if (sizeof($request->all())){
            $usuarios = $this->userService->usuarioBusca($request->get('nome'), $request->get('cidade'));
        }else{
            $usuarios = $this->userService->usuariosClientes();
        }

        $cidades = $this->cidadeService->listCidadesByUf('PA');

        return view('adm.usuarios.index')->with(array('usuarios' => $usuarios, 'cidades' => $cidades));
    }

    public function usuariodetalhe($id){
        $usuario = $this->userService->find($id);
        $plano = $usuario->planos()->first();

        $operadoras = $this->planoService->findParents();
        $operadorasOptions = array();

        foreach ($operadoras as $operadora) {
            $operadorasOptions[$operadora->id] = $operadora->titulo;
        }

        if (isset($plano->id)){
            $planos = $this->planoService->findChildren($plano->id_pai);
        }else{
            $planos = null;
        }

        return view("adm.usuarios.detalhe")->with(array('usuario' => $usuario,
            'plano' => $plano,
            'operadorasOptions' => $operadorasOptions,
            'operadoras' => $operadoras,
            'planos' => $planos));
    }

    public function updateUsuario(UpdatePerfilRequest $request)
    {
        $this->userService->updatePerfil($request->get('user_id'),$request);

//        $user = $this->userService->find($request->get('user_id'));
//
//        $planosParams['id_plano'] = $request->get('id_plano');
//        $planosParams['user_id'] = $user->id;
//        $planosParams['role'] = 0;
//
//        $user->planos()->sync($planosParams);

        return redirect()->route('adm.usuarios')->with("message",$this->messageService->getMessage('success'));
    }

    public function deleteusuario($user_id){
        $this->userService->destroy($user_id);

        return redirect()->route("adm.usuarios")->with("message", $this->messageService->getMessage('success'));
    }

    public function operadoras(){
        $planos = $this->planoService->findParents();

        return view("adm.planos.operadoras")->with("planos", $planos);
    }

    public function planos(){
        $planos = $this->planoService->all();

        return view("adm.planos.index")->with('planos', $planos);
    }

    public function novoplano(){
        return view("adm.planos.novo");
    }

    public function salvaplano(Request $request){
        $this->planoService->create($request->all());

        return redirect()->route("adm.planos.index")->with("message", $this->messageService->getMessage('success'));
    }

    public function editplano($id){
        $plano = $this->planoService->find($id);
        return view("adm.planos.edit")->with('plano', $plano);
    }

    public function updateplano(Request $request){
        $params = array();

        foreach ($request->all() as $field => $param) {
            $params[$field] = $param;
        }
        unset($params['id']);

        $idPlano = $this->planoService->update($request->get('id'), $params);

        return redirect()->route('adm.planos')->with('message', $this->messageService->getMessage('success'));
    }

    public function profissionais(){
        $profissionais = $this->userService->pesquisar(array(), 200);

        return view("adm.profissionais.index")->with('profissionais', $profissionais);
    }

    public function especialidades(){
        $especialidades = $this->especialidadeService->all();

        return view("adm.especialidades.index")->with('especialidades', $especialidades);
    }

    public function novaespecialidade(){
        return view("adm.especialidades.novo");
    }

    public function salvaespecialidade(Request $request){
        $this->especialidadeService->create($request->all());

        return redirect()->route("adm.especialidades")->with("message", $this->messageService->getMessage('success'));
    }

    public function editespecialidade($id){
        $especialidades = $this->especialidadeService->find($id);

        return view("adm.especialidades.edit")->with('especialidade', $especialidades);
    }

    public function updateespecialidade(Request $request)
    {
        $params = array();
        $id = $request->get('id');

        foreach ($request->all() as $field => $value) {
            $params[$field] = $value;
        }

        unset($params['id']);
        $this->especialidadeService->update($id, $params);

        return redirect()->route('adm.especialidades')->with("message", $this->messageService->getMessage('success'));
    }

    public function excluirespecialidade($id){
        $this->especialidadeService->destroy($id);

        return redirect()->route("adm.especialidades")->with("message", $this->messageService->getMessage('success'));
    }

    public function estados(){
        $estados = $this->estadoService->all();
        return view("adm.estados.index")->with('estados', $estados);
    }

    public function novoestado(){
        return view("adm.estados.novo");
    }

    public function salvaestado(Request $request){
        $this->estadoService->create($request);

        return redirect()->route("adm.estados")->with("message", $this->messageService->getMessage('success'));
    }

    public function editestado($id){
        $estado = $this->estadoService->find($id);

        return view("adm.estados.edit")->with('estado', $estado);
    }

    public function updateestado(Request $request){
        $params = array();
        $id = $request->get('id');

        foreach ($request->all() as $field => $value) {
            $params[$field] = $value;
        }

        unset($params['id']);
        $this->estadoService->update($id, $params);

        return redirect()->route("adm.estados")->with("message", $this->messageService->getMessage('success'));
    }

    public function excluirestado($id){
        $this->estadoService->destroy($id);

        return redirect()->route("adm.estados")->with("message", $this->messageService->getMessage('success'));
    }

    public function cidades(){
        $cidades = $this->cidadeService->all();

        return view("adm.cidades.index")->with('cidades', $cidades);
    }

    public function novacidade(){
        return view("adm.cidades.novo");
    }

    public function salvacidade(Request $request){
        $this->cidadeService->create($request->all());

        return redirect()->route("adm.cidades")->with("message", $this->messageService->getMessage('success'));
    }

    public function editcidade($id){
        $cidade = $this->cidadeService->find($id);

        return view("adm.cidades.edit")->with('cidade', $cidade);
    }

    public function updatecidade(Request $request){
        $params = array();
        $id = $request->get('id');

        foreach ($request->all() as $field => $value) {
            $params[$field] = $value;
        }

        unset($params['id']);
        $this->cidadeService->update($id, $params);

        return redirect()->route("adm.cidades")->with("message", $this->messageService->getMessage('success'));
    }

    public function excluircidade($id){
        $this->cidadeService->destroy($id);

        return redirect()->route("adm.cidades")->with("message", $this->messageService->getMessage('success'));
    }

}