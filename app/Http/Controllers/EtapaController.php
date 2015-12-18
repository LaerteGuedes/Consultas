<?php
namespace App\Http\Controllers;

use App\Services\AssinaturaService;
use App\Services\CidadeService;
use App\Services\GradeService;
use App\Services\LocalidadeService;
use App\Services\PlanoService;

class EtapaController extends Controller
{
    protected $localidadeService;
    protected $cidadeService;
    protected $gradeService;
    protected $assinaturaService;
    protected $planoService;

    public function __construct(LocalidadeService $localidadeService, CidadeService $cidadeService,
                                GradeService $gradeService, AssinaturaService $assinaturaService,
                                PlanoService $planoService)
    {
        $this->localidadeService = $localidadeService;
        $this->cidadeService = $cidadeService;
        $this->gradeService = $gradeService;
        $this->assinaturaService = $assinaturaService;
        $this->planoService = $planoService;
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

    public function plano()
    {
        $planosPai = $this->planoService->findParents();
        $planosPaiExistentes = $this->planoService->findParentsById(\Auth::user()->id);
        $planosFilho = $this->planoService->findAllChildrenCheckbox();
        $planosFilhoExistentes = $this->planoService->paginateByUser(\Auth::user()->id);
        $vPlanosPais = array();

        foreach ($planosPai as $key => $planoPai){
            $vPlanos[$planoPai->id] = $planoPai->toArray();
            if (sizeof($planosPaiExistentes)){
                foreach ($planosPaiExistentes as $planoPaiExistente){
                    if ($planoPai->id == $planoPaiExistente->id){
                        $vPlanos[$planoPai->id] = ['checked' => 'checked', 'titulo' => $planoPai->titulo];
                        break;
                    }else{
                        $vPlanos[$planoPai->id] = ['checked' => '', 'titulo' => $planoPai->titulo];
                    }
                }
            }
        }

        if (sizeof($planosPaiExistentes)){
            foreach ($vPlanos as $id => $plano){
                $vPlanos[$id]['filhos'] = $this->planoService->findChildren($id)->toArray();
            }
        }


        foreach ($vPlanos as $key => $plano){
            if (isset($plano['filhos'])){
                foreach ($plano['filhos'] as $keyFilho => $planoFilho){
                    if(sizeof($planosFilhoExistentes)){
                        foreach ($planosFilhoExistentes as $planoFilhoExistente){
                            if ($planoFilho['id'] == $planoFilhoExistente->id){
                                $vPlanos[$key]['filhos'][$keyFilho] = ['checked' => 'checked', 'titulo' => $planoFilhoExistente->titulo, 'id' => $planoFilho['id']];
                                break;
                            }else{
                                $vPlanos[$key]['filhos'][$keyFilho] = ['checked' => '', 'titulo' => $planoFilho['titulo'], 'id' => $planoFilho['id']];
                            }
                        }
                    }
                }
            }
        }

        return view("etapas.plano")->with('planos', $planosPai)->with('vPlanos', $vPlanos);
    }

    public function assinatura()
    {
        $user_id = \Auth::user()->id;
        $assinaturas = $this->assinaturaService->all();

        return view("assinatura.nova")->with(['assinaturas' => $assinaturas, 'user_id' => $user_id]);
    }
}