<?php

namespace App\Http\Controllers;

use App\Custom\Debug;
use App\Services\CidadeService;
use App\Services\RamoService;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Services\EstadoService;
use App\Services\UserService;
use App\Services\EspecialidadeService;


class PesquisaController extends Controller
{
    protected $estadoService;
    protected $userService;
    protected $especialidadeService;
    protected $comentarioService;
    protected $ramoService;
    protected $cidadeService;

    public function __construct(EstadoService $estadoService,
                                UserService $userService,
                                EspecialidadeService $especialidadeService,
                                RamoService $ramoService,
                                CidadeService $cidadeService)
    {
        $this->estadoService = $estadoService;
        $this->userService   = $userService;
        $this->especialidadeService = $especialidadeService;
        $this->ramoService = $ramoService;
        $this->cidadeService = $cidadeService;
    }


    public function index(Request $request)
    {
        $users =  $this->userService->pesquisar($request->all());

        $ramos = ($request->has('especialidade_id')) ? $this->ramoService->listarRamoByEspecialidadeCombo($request->get('especialidade_id')) : null;
        $ramo_id = ($request->has('ramo_id')) ? $request->get('ramo_id') : null;
        $cidades = $this->cidadeService->listCidadesAreaMetropolitanaBelemList();

        if ($request->has("data_desejada")){
            $data_desejada = $this->formataData($request->get('data_desejada'));
            $dia_semana_num = date('w', strtotime($data_desejada));
            $dia_semana = $this->dataSemana($dia_semana_num);

            foreach ($users as $key => $user) {
                $usuarioDisponivel = $this->userService->isProfissionalDisponivelAtDate($user->id, $data_desejada, $dia_semana);
                if (!$usuarioDisponivel){
                    $users->pull($key);
                }
            }
        }

        $cidades->prepend('Selecione a cidade','');

        return view('pesquisa.index')->with([
            'users' => $users,
            'ramos' => $ramos,
            'ramo_id' => $ramo_id,
            'cidades' => $cidades
        ]);
    }


    private function formataData($data){
        $dataUnf = explode('/', $data);
        $dia = $dataUnf[0];
        $mes = $dataUnf[1];
        $ano = $dataUnf[2];

        $dataF = $ano.'-'.$mes.'-'.$dia;
        return $dataF;
    }

    private function dataSemana($dateNum){

        switch($dateNum){
            case 0:
                return 'dom';
            case 1:
                return 'seg';
            case 2:
                return 'ter';
            case 3:
                return 'qua';
            case 4:
                return 'qui';
            case 5:
                return 'sex';
            case 6:
                return 'sab';
        }

    }

}
