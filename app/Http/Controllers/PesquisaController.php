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

        return view('pesquisa.index')->with([
            'users' => $users,
            'ramos' => $ramos,
            'ramo_id' => $ramo_id,
            'cidades' => $cidades
        ]);
    }

}
