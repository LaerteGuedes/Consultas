<?php

namespace App\Http\Controllers;

use App\Custom\Debug;
use App\Services\AssinaturaService;
use App\Services\AvisoService;
use App\Services\BairroService;
use App\Services\CalendarService;
use App\Services\ConsultaService;
use App\Services\CurriculoService;
use App\Services\GradeService;
use App\Services\LocalidadeService;
use App\Services\MailService;
use App\Services\MessageService;
use App\Services\PlanoService;
use App\Services\ServicoService;
use App\Services\UserEspecialidadeService;
use App\Services\UserRamoService;
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
use Illuminate\Http\Response;
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
    protected $assinaturaService;
    protected $userRamoService;
    protected $curriculoService;
    protected $servicoService;

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
        MessageService       $messageService,
        AssinaturaService    $assinaturaService,
        UserRamoService      $userRamoService,
        CurriculoService     $curriculoService,
        ServicoService       $servicoService
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
        $this->assinaturaService    = $assinaturaService;
        $this->userRamoService      = $userRamoService;
        $this->curriculoService     = $curriculoService;
        $this->servicoService       = $servicoService;
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
            if ($request->has('especialidade_id')){
                $params = $request->all();
                $params['user_id'] = $data->id;
                $this->userEspecialidadeService->create($params);
            }
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

    public function excluirConta(Request $request)
    {
        try{
            $this->userService->destroy($request->get("id"));
            $response = ['success' => true];

        }catch (Exception $ex){
            $response = ['success' => false];
        }

        return response()->json([
            'success' => true
        ]);
    }

    public function listarDadosProfissional(Request $request)
    {
        $data = $this->userService->listarDadosProfissionalApi($request->get('id'));
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

    public function comentariosPorUsuario(Request $request)
    {
        $comentarios = $this->userService->comentariosPorUsuario($request->get("id"), $request->get("profissional"));

        return response()->json([

            'success' => true,
            'data'    => $comentarios
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

    public function consultasProfissionalDatas(Request $request)
    {
        if($request->get('next_mes'))
        {
            $mes = $request->get('next_mes');
        }elseif($request->get('previous_mes'))
        {
            $mes = $request->get('previous_mes');
        }else
        {
            $mes = $this->calendarService->getMesAtual();
        }

        $next_mes = $this->calendarService->getNextMes($mes);
        $previous_mes = $this->calendarService->getPreviousMes($mes);

        $consultas = $this->consultaService->listarConsultasByProfissional($request->get('id') ,[
            'mes' => date('m', strtotime($mes)),
            'ano' => date('Y', strtotime($mes))
        ]);

        return response()->json([
            'mes'=>$mes,
            'next_mes'=> $next_mes,
            'previous_mes' => $previous_mes,
            'consultas' => $consultas
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

    public function getUser(Request $request)
    {
        $user = $this->userService->find($request->get('id'));

        if (isset($user->id)){
            return response()->json(['success' => true, 'user' => $user]);
        }else{
            return response()->json(['success' => false]);
        }
    }

    public function planosUsuario(Request $request)
    {
//        $planos = $this->planoService->findParents()->toArray();
//
//        foreach ($planos as $key => $plano) {
//            $planos[$key]['filhos'] = $this->planoService->findChildren($plano['id']);
//        }
//
//        $planosPaiExistentes = $this->planoService->findParentsById(2);
//        $planosFilhoExistentes = $this->planoService->paginateByUser(2)->toArray();
//
//        foreach ($planosPaiExistentes as $planoPai) {
//
//        }
//
//
//        Debug::dump($planosPaiExistentes, false);
//        Debug::dump($planosFilhoExistentes);

    }

    public function ramos(Request $request)
    {
        $ramos = $this->userRamoService->byUser($request->get('id'));
        return response()->json(['ramos' => $ramos]);
    }

    public function storeLocalidade(Request $request)
    {
        if ($request->has('localidade_id')){
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

            if($this->localidadeService->update($request->get('localidade_id'), $data))
            {
                return response()->json(['success' => true, 'message' => $this->messageService->getMessage('success')]);
            }

            return response()->json(['success' => false, 'message' => $this->messageService->getMessage('error')]);
        }

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

    public function localidadeDelete($id)
    {
        $this->localidadeService->destroy($id);

        return response()->json(['success' => true]);
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

    public function cancelarDia(Request $request)
    {
        try{
            $this->gradeService->cancelarDia($request->get('user_id'), $request->get('localidade_id'), $request->get('dia_semana'));
        }catch (Exception $ex){
            return \Response::json(['success' => false]);
        }

        return \Response::json(['success' => true]);
    }

    public function gradeDiasSemana(Request $request)
    {
        $response = $this->gradeService->getAllHorariosTurno($request->get('user_id'), $request->all());

        if (sizeof($response)){
            return \Response::json(['data' => $response]);
        }
    }

    public function deleteHorarioGrade($id)
    {
        if( $this->gradeService->destroy($id) )
        {
            return \Response::json(['message' => 'Horário excluído com sucesso!']);
        }
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
        }elseif($request->get('data_semana')){
            $semana_atual = $this->calendarService->getCustomSemana($request->get('data_semana'));
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
        $etapa = $this->userService->checkEtapa($request->get('user_id'));
        if (!$etapa){
            return response()->json(['canPass' => true]);
        }else{
            return response()->json(['canPass' => false, 'etapa' => $etapa]);
        }
    }

    public function operadoras(Request $request)
    {
        $operadoras = $this->planoService->findParents();
        $planos = array();
        foreach ($operadoras as $operadora) {
            $planos[$operadora->id] = $this->planoService->findChildren($operadora->id);
        }
        return response()->json(['operadoras' => $operadoras, 'planos' => $planos]);
    }

    public function planos(Request $request)
    {
        $user = $this->userService->find($request->get('user_id'));

        if ($user->nao_atende_planos == 1){
            return response()->json(['success' => 'true', 'planos' => null, 'operadoras' => null, 'nao_atende_planos' => 1]);
        }

        $operadoras = $this->planoService->findParents()->toArray();
        foreach ($operadoras as $key => $operadora) {
            $operadoras[$key]['checked'] = 0;
            $operadoras[$key]['planos'] = $this->planoService->findChildren($operadora['id'])->toArray();
        }

        foreach ($operadoras as $key => $operadora) {
            foreach ($operadoras[$key]['planos'] as $i => $plano) {
                $operadoras[$key]['planos'][$i]['checked'] = 0;
            }
        }

        $operadorasUsuario = $this->planoService->findParentsById($request->get('user_id'));
        $planosUsuario = $this->planoService->findChildrenById($request->get('user_id'));

        foreach ($operadorasUsuario as $key => $operadoraUsuario) {
            foreach ($planosUsuario as $key2 => $planoUsuario){
                if ($operadoraUsuario->id == $planoUsuario->id_pai){
                    $operadorasUsuario[$key]->planos[] = $planoUsuario;
                }
            }
        }

        foreach ($operadoras as $key => $operadora) {
            foreach ($operadorasUsuario as  $key2 => $operadoraUsuario) {
                 if ($operadora['id'] == $operadoraUsuario->id){
                    $operadoras[$key]['checked'] = true;
                     foreach ($operadoras[$key]['planos'] as $i => $plano) {
                        foreach ($operadorasUsuario[$key2]->planos as $planoUsuario) {
                             if ($plano['id'] == $planoUsuario->id){
                                 $operadoras[$key]['planos'][$i]['checked'] = 1;
                             }
                        }
                     }
                 }
            }
        }

        $planosArr = array();

        foreach ($operadoras as $key => $operadora) {
            $planosArr[$operadora['id']] = $operadoras[$key]['planos'];
            unset($operadoras[$key]['planos']);
        }


        return response()->json(['success' => 'true', 'operadoras' => $operadoras, 'planos' => $planosArr, 'nao_atende_planos' => 0]);
    }

    public function salvarPlanos(Request $request)
    {
        $planos = json_decode($request->get('planos'));
        $planos = array_filter($planos);

        if ($request->has('nao_atende_planos')){
            if ($request->get('nao_atende_planos')){
                $this->userService->userNaoAtendePlanos($request->get('user_id'));
                return response()->json(['success' => true, 'message' => 'salvo com sucesso!']);
            }
        }

        $user = $this->userService->find($request->get('user_id'));

        $isSaved = $user->planos()->sync($planos);

       // $isSaved = $this->planoService->insertUserPlanos($request->get('user_id'), $planos);

        if ($isSaved){
            return response()->json(['success' => true, 'message' => 'salvo com sucesso!']);
        }

        return response()->json(['success' => false, 'message' => 'Houve um problema com o cadastro!']);
    }


    public function assinatura(Request $request)
    {
        $user = $this->userService->find($request->get('user_id'));
        $userAssinatura = $user->userAssinatura()->first();

        if (isset($userAssinatura->id)){
            return response()->json(['hasAssinatura' => true, 'assinatura' => $userAssinatura]);
        }
        return response()->json(['hasAssinatura' => false]);
    }

    public function assinaturaStore(Request $request){
        $params = $request->all();

        if ($request->has('versao_teste')){
            $params = $request->all();
            $params['assinatura_status'] = 'PERIODO_TESTES';
            $params['assinatura_id'] = 5;
            $params['usou_periodo_testes'] = 1;
            $params['expiracao'] = date('Y-m-d h:i:s', strtotime("+30 days"));
        }

        $this->userService->saveUserAssinatura($request->get('user_id'), $params);

        if ($request->has('versao_teste')){
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }

    public function ramo($id)
    {
        $ramo = $this->userRamoService->find($id);
        $result = $ramo;
        $result->nome = $ramo->ramo->nome;


        return response()->json(['success' => true, 'ramo' => $ramo]);
    }

    public function ramoDelete($id)
    {
        $this->userRamoService->destroy($id);

        return response()->json(['success' => true]);
    }

    public function ramosStore(Request $request)
    {

        if ($request->get('id')){
            $checkRamo = $this->ramoService->getByNome($request->get('nome'));

            if (isset($checkRamo->id)){
                $this->userRamoService->update($request->get('id'),['ramo_id'=> $checkRamo->id , 'user_id' => $request->get('user_id')]);
                return response()->json(['success' => true]);
            }

            $data = ['nome' => $request->get('nome'), 'especialidade_id' => $request->get('especialidade_id')];
            $ramo  = $this->ramoService->create($data);

            $this->userRamoService->update($request->get('id'), ['ramo_id'=> $ramo->id , 'user_id' => $request->get('user_id')]);
            return response()->json(['success' => true]);
        }

        $checkRamo = $this->ramoService->getByNome($request->get('nome'));

        if (isset($checkRamo->id)){
            $this->userRamoService->create(['ramo_id'=> $checkRamo->id , 'user_id' => $request->get('user_id')]);
            return response()->json(['success' => true]);
        }

        $data = ['nome' => $request->get('nome'), 'especialidade_id' => $request->get('especialidade_id')];
        $ramo  = $this->ramoService->create($data);
        $this->userRamoService->create(['user_id' => $request->get('user_id'), 'ramo_id' => $ramo->id]);
        return response()->json(['success' => true]);
    }
    
    
    public function curriculos($user_id){
        $curriculos = $this->curriculoService->byUser($user_id);

        return response()->json(['success' => true, 'curriculos' => $curriculos]);
    }

    public function curriculo($id){
        $curriculo = $this->curriculoService->find($id);

        return response()->json(['success' => true, 'curriculo' => $curriculo]);
    }

    public function curriculoStore(Request $request){
        if ($request->get('id')){
            $this->curriculoService->update($request->get('id'), ['descricao' => $request->get('descricao')]);

        }else{
            $this->curriculoService->create($request->all());

        }

        return response()->json(['success' => true]);
    }
    
    public function curriculoDelete($id){
        $this->curriculoService->destroy($id);

        return response()->json(['success' => true]);
    }

    public function servicos($user_id){
        $servicos = $this->servicoService->byUser($user_id);

        return response()->json(['success' => true, 'servicos' => $servicos]);
    }

    public function servico($id){
        $servico = $this->servicoService->find($id);

        return response()->json(['success' => true, 'servico' => $servico]);
    }

    public function servicoStore(Request $request){
        if ($request->get('id')){
            $this->servicoService->update($request->get('id'), ['nome' => $request->get('nome')]);

        }else{
            $this->servicoService->create($request->all());

        }

        return response()->json(['success' => true]);
    }

    public function servicoDelete($id){
        $this->servicoService->destroy($id);

        return response()->json(['success' => true]);
    }

    public function assinaturaLista(Request $request)
    {
        $assinaturas = $this->assinaturaService->all();

        return response()->json(['assinaturas' => $assinaturas]);
    }

}
