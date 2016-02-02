<?php

namespace App\Http\Controllers;

use App\Custom\Debug;
use App\Services\AvisoService;
use App\Services\BairroService;
use App\Services\CalendarService;
use App\Services\ConsultaService;
use App\Services\GradeService;
use App\Services\LocalidadeService;
use App\Services\MailService;
use App\Services\MessageService;
use App\Services\PlanoService;
use App\Services\UserEspecialidadeService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Services\UserService;
use App\Services\EstadoService;
use App\Services\CidadeService;
use App\Services\EspecialidadeService;
use App\Services\RamoService;
use App\Services\ComentarioService;
use App\Services\AvaliacaoService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;


class ServerController extends Controller
{
    protected $userService;
    protected $estadoService;
    protected $cidadeService;
    protected $bairroService;
    protected $especialidadeService;
    protected $ramoService;
    protected $comentarioService;
    protected $avaliacaoService;
    protected $localidadeService;
    protected $avisoService;
    protected $gradeService;
    protected $calendarService;
    protected $consultaService;
    protected $userEspecialidadeService;
    protected $planoService;
    protected $mailService;
    protected $messageService;

    public function __construct(
        UserService          $userService,
        EstadoService        $estadoService,
        CidadeService        $cidadeService,
        BairroService        $bairroService,
        EspecialidadeService $especialidadeService,
        RamoService          $ramoService,
        ComentarioService    $comentarioService,
        AvaliacaoService     $avaliacaoService,
        LocalidadeService	 $localidadeService,
        AvisoService		 $avisoService,
        GradeService		 $gradeService,
        CalendarService		 $calendarService,
        ConsultaService      $consultaService,
        UserEspecialidadeService $userEspecialidadeService,
        PlanoService         $planoService,
        MailService          $mailService,
        MessageService       $messageService
    )
    {

        $this->userService          = $userService;
        $this->estadoService        = $estadoService;
        $this->cidadeService        = $cidadeService;
        $this->especialidadeService = $especialidadeService;
        $this->ramoService          = $ramoService;
        $this->comentarioService    = $comentarioService;
        $this->avaliacaoService     = $avaliacaoService;
        $this->localidadeService    = $localidadeService;
        $this->avisoService		    = $avisoService;
        $this->gradeService			= $gradeService;
        $this->calendarService		= $calendarService;
        $this->consultaService      = $consultaService;
        $this->bairroService        = $bairroService;
        $this->userEspecialidadeService = $userEspecialidadeService;
        $this->planoService         = $planoService;
        $this->mailService          = $mailService;
        $this->messageService       = $messageService;
    }

    public function listarEstados()
    {
        $data = $this->estadoService->listarEstadosApi();

        return response()->json([

            'success' => true,
            'data'    => $data
        ]);
    }

    public function listarLocalidades(Request $request){
        $localidades = $this->localidadeService->getComplete($request->get('id'));
        return response()->json(['localidades' => $localidades]);
    }

    public function confirmarConsulta(Request $request)
    {
        $response = $this->consultaService->confirmarConsulta($request->all());

        return response()->json(['success'=> $response ]);
    }

    public function localidadeDetalhe($id){

        $localidade = $this->localidadeService->getCompleteFirst($id);

        if ($localidade){
            $success = true;
            $data = ['localidade' => $localidade];
        }else{
            $success = false;
            $data = [];
        }

        return response()->json(['success' => $success, 'data' => $data]);
    }


    public function listarCidades(Request $request)
    {
        $uf = $request->get('uf');

        if($uf)
        {
            $data = $this->cidadeService->listarCidadesApi($uf);
        }else
        {
            $data = [];
        }
        return response()->json([

            'success' => true,
            'data'    => $data
        ]);

    }

    public function listarBairros(Request $request)
    {
       $cidade_id = $request->get('cidade_id');

       if ($cidade_id){
           $data = $this->bairroService->listBairroByCidadeOnlyUnique($cidade_id);
       }

        return response()->json([
           'data' => $data
        ]);
    }

    public function listarEspecialidades()
    {
        $data = $this->especialidadeService->listarEspecialidadesApi();

        return response()->json([
            'success' => true,
            'data'    => $data
        ]);
    }

    public function listarRamos(Request $request)
    {
        $especialidade_id = $request->get('especialidade_id');

        if($especialidade_id)
        {
            $data = $this->ramoService->listarRamosApi($especialidade_id);
        }else
        {
            $data = [];
        }
        return response()->json([

            'success' => true,
            'data'    => $data
        ]);
    }

    public function pesquisarProfissional(Request $request)
    {
        $data = $this->userService->pesquisar($request->all());

        return response()->json([

            'success' => true,
            'data'    => $data->toArray()
        ]);
    }


    public function logarUsuario(Request $request)
    {
        $data = $this->userService->logarUsuarioApi( $request->all() );

        if($data)
        {
            $success = true;

        }else
        {
            $success = false;
            $data = [];

        }
        return response()->json([

            'success' => $success,
            'data'    => $data
        ]);
    }

    public function registrarNovoUsuario(Request $request)
    {
        $data = $this->userService->registrarNovoUsuarioApi( $request->all() );

        if($data)
        {
            $success = true;
        }else
        {
            $success = false;
            $data = [];
        }
        return response()->json([
            'success' => $success,
            'data'    => $data
        ]);
    }

    public function usuarioDetalhe(Request $request){
        $user = $this->userService->find($request->get('id'));

        if($user)
        {
            $success = true;
            $data = ['user' => $user];
        }else
        {
            $success = false;
            $data = [];
        }

        return response()->json(['success' => $success, 'data' => $data]);
    }

    public function editarUsuario(Request $request)
    {
        $params = $request->all();

        try{
            $this->userService->editarUsuarioApi($params);
        }catch (Exception $ex){
            $error = $ex->getMessage();
            return response()->json([
                'error' => $error
            ]);
        }

        $data = ['message' => 'Perfil editado com sucesso'];

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function getTotalComentarioProfissional(Request $request)
    {
        $data = $this->comentarioService->getTotalComentarioProfissional( $request->get('id') );

        if($data)
        {
            $success = true;

        }else
        {
            $success = false;
            $data = [];

        }
        return response()->json([

            'success' => $success,
            'data'    => $data
        ]);

    }

    public function listarDadosProfissional(Request $request)
    {
        $data = $this->userService->listarDadosProfissionalApi( $request->get('id') );
        if($data)
        {
            $success = true;

        }else
        {
            $success = false;
            $data = [];

        }
        return response()->json([

            'success' => $success,
            'data'    => $data
        ]);

    }

    public function listarComentariosProfissional(Request $request)
    {

        $data = $this->userService->listarComentariosProfissionalApi( $request->get('id') );

        if($data)
        {
            $success = true;

        }else
        {
            $success = false;
            $data = [];

        }
        return response()->json([

            'success' => $success,
            'data'    => $data
        ]);

    }

    public function avaliarProfissional(Request $request)
    {
        $success = false;

        if($this->avaliacaoService->create($request->all()))
        {
            $success = true;
        }

        return response()->json([

            'success' => $success,


        ]);
    }
    public function enviarComentario(Request $request)
    {
        $success = false;

        if($this->comentarioService->create($request->all()))
        {
            $success = true;
        }

        return response()->json([

            'success' => $success,


        ]);
    }

    public function avisos(Request $request)
    {
        $avisos = $this->avisoService->listarAvisosDetalhesByUser($request->get('user_id'));
        $this->avisoService->atualizaViewByCliente($request->get('user_id'));

        foreach ($avisos as $key => $aviso) {
            $date = explode('-',$aviso->data_agenda);
            $year = $date[0];
            $month = $date[1];
            $day = $date[2];
            $avisos[$key]->data_format = $day.'/'.$month.'/'.$year;

            $createdAtdate = explode(' ', $aviso->created_at);
            $createdAtDateFormat = explode('-',$createdAtdate[0]);
            $yearCreated = $createdAtDateFormat[0];
            $monthCreated = $createdAtDateFormat[1];
            $dayCreated = $createdAtDateFormat[2];

            $avisos[$key]->data_created_format = $dayCreated.'/'.$monthCreated.'/'.$yearCreated;
        }


        return response()->json([
            'avisos' => $avisos
        ]);
    }

    public function avisosProfissional(Request $request)
    {
        $avisos = $this->avisoService->listarAvisosDetalhesByProfissional($request->get('profissional_id'));
        $this->avisoService->atualizaViewByProfissional($request->get('profissional_id'));

        foreach ($avisos as $key => $aviso) {
            $date = explode('-',$aviso->data_agenda);
            $year = $date[0];
            $month = $date[1];
            $day = $date[2];
            $avisos[$key]->data_format = $day.'/'.$month.'/'.$year;

            $createdAtdate = explode(' ', $aviso->created_at);
            $createdAtDateFormat = explode('-',$createdAtdate[0]);
            $yearCreated = $createdAtDateFormat[0];
            $monthCreated = $createdAtDateFormat[1];
            $dayCreated = $createdAtDateFormat[2];

            $avisos[$key]->data_created_format = $dayCreated.'/'.$monthCreated.'/'.$yearCreated;
        }


        return response()->json([
            'avisos' => $avisos
        ]);
    }

    public function confirmar(Request $request)
    {
        $usuario      = $this->userService->find($request->get('user_id'));
        $profissional = $this->userService->find($request->get('profissional_id'));
        $localidade   = $this->localidadeService->find($request->get('localidade_id'));

        return response()->json([
            'usuario'      => $usuario,
            'profissional' => $profissional,
            'localidade'   => $localidade,
            'dia_agenda'   => $request->get('dia_agenda'),
            'horario_agenda' => $request->get('horario_agenda')
        ]);
    }

    public function finalizar(Request $request)
    {
        if($this->consultaService->create($request->all()))
        {
            $success = true;
        }else{
            $success = false;
        }

        return response()->json([
            'success' => $success
        ]);
    }

    public function consultas(Request $request)
    {
        $id = $request->get('id');

        $futuras    = $this->consultaService->listarConsultasFuturasByUserWithProfissional($id);
        $historicos = $this->consultaService->listarConsultasHistoricoByUserWithProfissional($id);

        return response()->json([
            'futuras'    => $futuras,
            'historicos' => $historicos
        ]);
    }

    public function consultaDetalhe($id){
        $consulta = $this->consultaService->find($id);
        $localidade = $this->localidadeService->getCompleteFirst($consulta->localidade_id);
    
        if ($consulta->id){
            $success = true;
            $data = ['consulta' => $consulta, 'localidade' => $localidade];
        }else{
            $success = false;
            $data = '';
        }

        return response()->json([
            'success' => $success,
            'data' => $data
        ]);
    }

    public function consultasByDataFuturas(Request $request)
    {
        $id = $request->get('id');
        $date = $request->get('data_agenda');

        $futuras = $this->consultaService->listarConsultasFuturasByUserAndDate($id, $date);

        return response()->json([
            'futuras' => $futuras
        ]);
    }

    public function consultasByDataHistorico(Request $request)
    {
        $id = $request->get('id');
        $date = $request->get('data_agenda');

        $historico    = $this->consultaService->listarConsultasHistoricoByUserAndDate($id, $date);

        return response()->json([
            'historico'    => $historico
        ]);
    }

    public function consultasDatas(Request $request)
    {
        $id = $request->get('id');

        $futuras    = $this->consultaService->listarConsultasDatasFuturas($id);
        $historicos = $this->consultaService->listarConsultasDatasHistorico($id);

        return response()->json([
            'futuras'    => $futuras,
            'historicos' => $historicos
        ]);
    }

    public function registerUser(Request $request)
    {
        $user_exist = $this->userService->findBy('email', $request->get('email'));
        if (isset($user_exist)){
            return response()->json(['success' => false, 'message' => 'O email já foi cadastrado!']);
        }

        $this->userService->register($request->all());
        $user = $this->userService->findBy('email', $request->get('email'));

        if ($request->has('especialidade_id')){
            $params = $request->all();
            $params['user_id'] = (isset($user->id)) ? $user->id : '';
            $this->userEspecialidadeService->create($params);
        }
        if (isset($user->id)){
            $planos = array($request->input('id_plano'));
            $this->planoService->insertUserPlanos($user->id, $planos);
            $this->mailService->sendBoasVindas($user);

            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false, 'message' => 'Houve um problema com o cadastro!']);
    }

    public function storeLocalidade(Request $request)
    {
        if (!$request->has('user_id')){
            return response()->json(['success' => false, 'message' => 'Você precisa informar o usuário']);
        }
        $data = array_add( $request->all() , 'user_id' , $request->get("user_id") );

        if(!$request->get('bairro_id'))
        {
            $bairro    = $this->bairroService->create([
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
            return response()->json(['success' => true, 'message' => $this->messageService->getMessage('success')]);
        }

        return response()->json(['success' => false, 'message' => $this->messageService->getMessage('error')]);
    }

    public function storeGrade(Request $request)
    {
        $response = $this->gradeService->save($request->get('id'),$request->all());
        if (is_array($response)){
            $message = 'O horário '.$response['horario'].' está incompatível com outros horários que você possui.';
            return \Response::json(['message'=> $message]);
        }
        return \Response::json(['data'=> $response]);
    }

    public function detalhesProfissional($user_id, $localidade_id, Request $request)
    {
        $dias_semanais = $this->gradeService->getDiasSemanais();
        $turnos = $this->gradeService->getTurnos();

        $grade = array();


        foreach ($dias_semanais as $sigla_dia => $dia_semana) {
            foreach ($turnos as $sigla_turno => $turno) {
                $horariosTurno = $this->gradeService->getHorariosPorLocalidadeByUser($user_id, $localidade_id, $sigla_dia, $sigla_turno)->toArray();
                foreach ($horariosTurno as $key => $horario) {
                    if ($key == 0) {
                        $grade['dias'][$sigla_dia]['turnos'][$sigla_turno]['menor_valor'] = $horario['horario'];
                    }elseif($key == (count($horariosTurno)-1)){
                        $grade['dias'][$sigla_dia]['turnos'][$sigla_turno]['maior_valor'] = $horario['horario'];
                    }
                }
            }
        }

        return response()->json([
            'grade' => $grade
        ]);
    }

    public function agendar($user_id, $localidade_id, Request $request)
    {
        $user =  $this->userService->find($user_id);
        $localidade = $this->localidadeService->find($localidade_id);
        $dias_semanais = $this->gradeService->getDiasSemanais();
        $turnos = $this->gradeService->getTurnos();
        if ($request->get('next')) {
            $semana_atual = $this->calendarService->getNextSemana($request->get('next'));
        }
        elseif($request->get('previous')){
            $semana_atual = $this->calendarService->getPreviousSemana($request->get('previous'));
        }else {
            $semana_atual = $this->calendarService->getSemanaAtual();
        }

        foreach ($semana_atual as $key => $dia) {
            $semana_atual[$key] = ['dia' => $dia, 'diaF' => date('d/m',strtotime($dia))];
        }

        $grade = array();


        foreach ($semana_atual as $dia_semana => $dia) {
            $aux = array();
            $aux['dia_semana'] = $dia_semana;
            $aux['dia'] = $dia;

            foreach($turnos as $sigla_turno => $turno){

                $horarios = $this->gradeService->getHorariosAtualPorLocalidadeByUser($user->id, $localidade->id, $dia_semana, $dia['dia'], $sigla_turno);
                $aux['turnos'][$turno]['horarios'] = $horarios;
            }

            $grade[] = $aux;
        }

        $primeiroDiaDaSemana = $semana_atual['seg'];

        return response()->json([
            'user' => $user,
            'localidade' => $localidade,
            'dias_semanais' => $dias_semanais,
            'turnos' => $turnos,
            'semana_atual' => $semana_atual,
            'grade' => $grade,
            'primeiroDiaDaSemana' => $primeiroDiaDaSemana
        ]);
    }

    public function buscaAvancada(Request $request)
    {
        $users = $this->userService->pesquisar($request->all())->toArray();

        return response()->json([
            'users' => $users
        ]);
    }

    public function profissionalEtapa(Request $request)
    {
        $etapa = $this->userService->getProfissionalEtapa($request->get('user_id'));

        if ($etapa === true){
            return response()->json(['success' => true, 'etapa' => 'next']);
        }elseif($etapa){
            return response()->json(['success' => true, 'etapa' => $etapa]);
        }
        return response()->json(['success' => false]);
    }

}
