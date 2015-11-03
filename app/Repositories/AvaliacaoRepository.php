<?php
/**
 * Created by PhpStorm.
 * User: hugomachado
 * Date: 29/08/15
 * Time: 23:45
 */

namespace App\Repositories;

use App\Repository;
use App\Contracts\AvaliacaoRepositoryInterface;
use App\Avaliacao;


class AvaliacaoRepository extends Repository implements AvaliacaoRepositoryInterface
{
    public function __construct(Avaliacao $avaliacao)
    {
        $this->model = $avaliacao;
    }

    public function getAvaliacaoUsuarioParaProfissional($avaliador,$user_id)
    {
    	return $this->model->where('avaliador',$avaliador)
    					   ->where('user_id',$user_id)
    					   ->avg('nota');
    }

    public function getAvaliacaoProfissional($user_id)
    {

    	return $this->model->where('user_id',$user_id)
    					   ->avg('nota');
    }
} 