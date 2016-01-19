<?php
/**
 * Created by PhpStorm.
 * User: hugomachado
 * Date: 29/08/15
 * Time: 22:59
 */

namespace App\Repositories;

use App\Contracts\LocalidadeRepositoryInterface;
use App\Custom\Debug;
use App\Repository;
use App\Localidade;
use Illuminate\Support\Facades\DB;


class LocalidadeRepository extends Repository implements LocalidadeRepositoryInterface
{
    public function __construct(Localidade $localidade)
    {
        $this->model = $localidade;
    }

    public function getTipos()
    {
        return $this->model->getTipos();
    }

    public function getComplete($id)
    {
        return DB::table('localidades')
            ->join('cidades', 'localidades.cidade_id', '=', 'cidades.id')
            ->join('bairros', 'localidades.bairro_id', '=', 'bairros.id')
            ->where('localidades.user_id', '=', $id)
            ->select('localidades.id as localidade_id',
                'bairros.id as bairro_id', 'cidades.id as cidade_id',
                'logradouro', 'bairros.nome as bairro_nome', 'cidades.nome as cidade_nome',
                'numero', 'preco', 'tipo', 'cep')
            ->get();
    }

    public function getCompleteFirst($id)
    {
        return DB::table('localidades')
            ->join('cidades', 'localidades.cidade_id', '=', 'cidades.id')
            ->join('bairros', 'localidades.bairro_id', '=', 'bairros.id')
            ->where('localidades.id', '=', $id)
            ->select('localidades.id as localidade_id',
                'bairros.id as bairro_id', 'cidades.id as cidade_id',
                'logradouro', 'bairros.nome as bairro_nome', 'cidades.nome as cidade_nome',
                'numero', 'preco', 'tipo', 'cep', 'localidades.uf')
            ->first();
    }

    public function paginateByUser($id)
    {
        return $this->model->where('user_id',$id)->paginate();
    }

    public function listForComboByUser($id)
    {
        $data = [];
        $locais = $this->model->where('user_id',$id)->get();

        if($locais)
        {
            foreach($locais as $local)
            {
                if ($local->tipo == 'DOMICILIO'){
                    $localTexto = sprintf("%s, %s, %s - %s" , $this->model->getTipos()[$local->tipo] ,$local->bairro->nome,$local->cidade->nome,$local->uf);
                }else{
                    $localTexto = sprintf("%s - %s %s, %s, %s - %s" , $this->model->getTipos()[$local->tipo] ,$local->logradouro,$local->numero,$local->bairro->nome,$local->cidade->nome,$local->uf);
                }
                $data[] = [
                    'id' => $local->id,
                    'local' => $localTexto
                ];
            }
        }

        return $data;
    }
} 