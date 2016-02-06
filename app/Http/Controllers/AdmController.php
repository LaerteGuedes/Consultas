<?php

namespace App\Http\Controllers;

use App\Custom\Date;
use App\Custom\Debug;
use App\Http\Requests\UpdatePerfilRequest;
use App\Role;
use App\Services\AssinaturaService;
use App\Services\AvaliacaoService;
use App\Services\BairroService;
use App\Services\CidadeService;
use App\Services\ConsultaService;
use App\Services\EspecialidadeService;
use App\Services\EstadoService;
use App\Services\MessageService;
use App\Services\PlanoService;
use App\Services\RamoService;
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
    protected $ramoService;
    protected $assinaturaService;
    protected $bairroService;

    public function __construct(UserService $userService,
                                PlanoService $planoService,
                                EspecialidadeService $especialidadeService,
                                EstadoService $estadoService,
                                CidadeService $cidadeService,
                                MessageService $messageService,
                                ConsultaService $consultaService,
                                AvaliacaoService $avaliacaoService,
                                RamoService $ramoService,
                                AssinaturaService $assinaturaService,
                                BairroService $bairroService)
    {
        $this->userService = $userService;
        $this->planoService = $planoService;
        $this->especialidadeService = $especialidadeService;
        $this->estadoService = $estadoService;
        $this->cidadeService = $cidadeService;
        $this->messageService = $messageService;
        $this->consultaService = $consultaService;
        $this->avaliacaoService = $avaliacaoService;
        $this->ramoService = $ramoService;
        $this->assinaturaService = $assinaturaService;
        $this->bairroService = $bairroService;
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
        }else{
            return redirect()->route("adm.login")->with('message', 'Login incorreto! Tente novamente');
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
        $totalProfissionaisAtivos = $this->userService->totalProfissionalAssinaturaByStatus('APROVADO');
        $totalProfissionaisTeste = $this->userService->totalProfissionalAssinaturaByStatus('PERIODO_TESTES');
        $totalProfissionaisInativos = $this->userService->totalProfissionalInativo();
        $valorAssinaturas = $this->userService->assinaturasMensais();

        return view("adm.dashboard")->with(['totalUsuarios' => $totalUsuarios,
            'totalAgendadas' => $totalAgendadas,
            'totalRealizadas' => $totalRealizadas,
            'totalCanceladas' => $totalCanceladas,
            'totalAvaliacoes' => $totalAvaliacoes,
            'totalProfissionais' => $totalProfissionais,
            'totalProfissionaisAtivos' => $totalProfissionaisAtivos,
            'totalProfissionaisTeste' => $totalProfissionaisTeste,
            'totalProfissionaisInativos' => $totalProfissionaisInativos,
            'valorAssinaturas' => $valorAssinaturas]);
    }

    public function usuarios(Request $request){
        if (sizeof($request->all())){
            $usuarios = $this->userService->usuarioBusca($request->get('nome'), $request->get('cidade'));
        }else{
            $usuarios = $this->userService->usuariosClientes();
        }

        //$cidades = $this->cidadeService->listCidadesByUf('PA');

        return view('adm.usuarios.index')->with(array('usuarios' => $usuarios));
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
        $operadoras = $this->planoService->findParentsAdm();

        return view("adm.planos.operadoras")->with("operadoras", $operadoras);
    }
    
    public function novaOperadora(){
        return view("adm.planos.novaoperadora");
    }

    public function salvaOperadora(Request $request){
        $this->planoService->create($request->all());

        return redirect()->route("adm.operadoras")->with("message", $this->messageService->getMessage('success'));
    }
    
    public function updateOperadora(Request $request){
        $this->planoService->update($request->get('id'), $request->all());

        return redirect()->route("adm.operadoras")->with("message", $this->messageService->getMessage('success'));
    }

    public function editOperadora($id){
        $operadora = $this->planoService->find($id);
        return view("adm.planos.editoperadora")->with('operadora', $operadora);
    }

    public function excluirOperadora($id){
        $this->planoService->destroy($id);
        return redirect()->route("adm.operadoras")->with("message", $this->messageService->getMessage('success'));
    }

    public function planos(){
        $planos = $this->planoService->all();

        return view("adm.planos.index")->with('planos', $planos);
    }

    public function novoplano($id_pai){
        $operadora = $this->planoService->find($id_pai);

        return view("adm.planos.novo")->with('operadora', $operadora);
    }

    public function salvaplano(Request $request){
        $this->planoService->create($request->all());

        return redirect()->route("adm.operadoras")->with("message", $this->messageService->getMessage('success'));
    }

    public function editplano($id){
        $plano = $this->planoService->find($id);
        return view("adm.planos.edit")->with('plano', $plano);
    }

    public function excluirPlano($id)
    {
        $this->planoService->destroy($id);
        return response()->json(['message' => 'Plano removido com sucesso!']);
    }

    public function updateplano(Request $request){
        $params = array();

        foreach ($request->all() as $field => $param) {
            $params[$field] = $param;
        }
        unset($params['id']);
        $idPlano = $this->planoService->update($request->get('id'), $params);

        return redirect()->route('adm.operadoras')->with('message', $this->messageService->getMessage('success'));
    }

    public function profissionais(Request $request){
        $profissionais = $this->userService->pesquisar($request->all(), 10);
        $cidades = $this->cidadeService->listCidadesByUf('PA');
        $especialidades = $this->especialidadeService->all();

        return view("adm.profissionais.index")->with(array('profissionais' => $profissionais,
                                                            'cidades' => $cidades,
                                                            'especialidades' => $especialidades));
    }

    public function profissionalDetalhe($id){
        $profissional = $this->userService->find($id);
        $assinatura = $profissional->userAssinatura()->first();
        $assinatura->data_format = Date::toViewAndHour($assinatura->expiracao);

        return view("adm.profissionais.detalhe")->with(['profissional' => $profissional, 'assinatura' => $assinatura]);
    }

    public function profissionalUpdate(Request $request){
        $this->userService->updatePerfil($request->get('user_id'),$request);

        return redirect()->route("adm.profissionais")->with("message", $this->messageService->getMessage('success'));
    }

    public function especialidades(){
        $especialidades = $this->especialidadeService->all();

        return view("adm.especialidades.index")->with('especialidades', $especialidades);
    }

    public function novaespecialidade(){
        return view("adm.especialidades.nova");
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

    public function novoRamo($especialidade_id){
        $especialidade = $this->especialidadeService->find($especialidade_id);
        return view("adm.ramos.novo")->with('especialidade', $especialidade);
    }

    public function excluirRamo($id){
        try{
            $this->ramoService->destroy($id);
            return response()->json(['message' => 'Exclusão realizada com sucesso!']);
        }catch (Exception $ex){
            return response()->json(['message' => 'Houve um problema com a exclusão, tente novamente mais tarde!']);
        }
    }
    
    public function salvaRamo(Request $request){
        $this->ramoService->create($request->all());

        return redirect()->route("adm.especialidades")->with("message", $this->messageService->getMessage('success'));
    }

    public function updateRamo(Request $request)
    {
        $params = array();
        $id = $request->get('id');

        foreach ($request->all() as $field => $value) {
            $params[$field] = $value;
        }

        unset($params['id']);
        $this->ramoService->update($id, $params);

        return redirect()->route('adm.especialidades')->with("message", $this->messageService->getMessage('success'));
    }

    public function bairros(Request $request){

        $cidades = $this->cidadeService->listCidadesAreaMetropolitanaBelem();

        if ($request->has('cidade_id')){
            $bairros = $this->bairroService->listBairroByCidadeOnlyUnique($request->get('cidade_id'));
        }else{
            $bairros = $this->bairroService->all();
        }

        return view("adm.bairros.index")->with(['bairros' => $bairros, 'cidades' => $cidades]);
    }

    public function salvabairro(Request $request){
        $this->bairroService->create($request->all());

        return redirect()->route("adm.bairros")->with("message", $this->messageService->getMessage('success'));
    }

    public function updatebairro(Request $request){
        $params = array();
        $id = $request->get('id');

        foreach ($request->all() as $field => $value) {
            $params[$field] = $value;
        }

        unset($params['id']);
        $this->bairroService->update($id, $params);

        return redirect()->route("adm.bairros")->with("message", $this->messageService->getMessage('success'));
    }

    public function excluirbairro($id){
        $this->bairroService->destroy($id);

        return redirect()->route("adm.bairros")->with("message", $this->messageService->getMessage('success'));
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

    public function assinaturas(){
        $assinaturas = $this->assinaturaService->assinaturasAdm();

        return view("adm.assinaturas.index")->with('assinaturas', $assinaturas);
    }
    
    public function novaAssinatura(){
        return view("adm.assinaturas.nova");
    }

    public function salvaAssinatura(Request $request){
        $this->assinaturaService->create($request->all());

        return redirect()->route("adm.assinaturas")->with("message", $this->messageService->getMessage('success'));
    }

    public function editAssinatura($id){
        $assinatura = $this->assinaturaService->find($id);

        return view("adm.assinaturas.edit")->with('assinatura', $assinatura);
    }
    
    public function updateAssinatura(Request $request){
        $this->assinaturaService->update($request->get('id'), $request->all());

        return redirect()->route("adm.assinaturas")->with("message", $this->messageService->getMessage('success'));
    }
    
    public function excluirAssinatura($id){
        $this->assinaturaService->destroy($id);

        return redirect()->route("adm.assinaturas")->with("message", $this->messageService->getMessage('success'));
    }

}