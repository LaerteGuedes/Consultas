<?php

namespace App\Http\Controllers;

use App\Custom\Debug;
use App\Services\AvisoService;
use App\Services\BairroService;
use App\Services\CalendarService;
use App\Services\ConsultaService;
use App\Services\GradeService;
use App\Services\LocalidadeService;
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
        ConsultaService      $consultaService
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
        $avisos = $this->avisoService->listarAvisosByCliente($request->get('user_id'));
        $this->avisoService->atualizaViewByCliente($request->get('user_id'));

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

}
