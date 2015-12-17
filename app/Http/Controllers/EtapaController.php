<?php
namespace App\Http\Controllers;

use App\Services\CidadeService;
use App\Services\GradeService;
use App\Services\LocalidadeService;

class EtapaController extends Controller
{
    protected $localidadeService;
    protected $cidadeService;
    protected $gradeService;

    public function __construct(LocalidadeService $localidadeService, CidadeService $cidadeService, GradeService $gradeService)
    {
        $this->localidadeService = $localidadeService;
        $this->cidadeService = $cidadeService;
        $this->gradeService = $gradeService;
    }

    public function localidade()
    {
        $estados = array('PA' => 'PA');
        $cidades = $this->cidadeService->listCidadesAreaMetropolitanaBelem();
        $tipos   = $this->localidadeService->getTipos();

        return view('etapas.localidade')->with([
            'estados' => $estados,
            'cidades_belem' => $cidades,
            'tipos'   => $tipos
        ]);
    }

    public function grade()
    {
        $localidades   = $this->localidadeService->listForComboByUser(\Auth::user()->id);
        $dias_semanais = $this->gradeService->getDiasSemanais();
        $turnos        = $this->gradeService->getTurnos();
        $horasManha = $this->gradeService->getHoras(6, 12);
        $horasTarde = $this->gradeService->getHoras(12, 18);
        $horasNoite = $this->gradeService->getHoras(18, 23);
        $intervalos    = $this->gradeService->getIntervalos();
        $intervalos_abreviados    = $this->gradeService->getIntervalosAbreviados();

        return view('etapas.grade')->with([
            'localidades'   => $localidades,
            'turnos'        => $turnos,
            'dias_semanais' => $dias_semanais,
            'gradeService'  => $this->gradeService,
            'horasManha'    => $horasManha,
            'horasTarde'    => $horasTarde,
            'horasNoite'    => $horasNoite,
            'intervalos'    => $intervalos,
            'intervalos_abreviados' => $intervalos_abreviados
        ]);
    }
}