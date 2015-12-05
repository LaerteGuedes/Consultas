<?php
/**
 * Created by PhpStorm.
 * User: hugomachado
 * Date: 29/08/15
 * Time: 23:47
 */

namespace App\Services;

use App\Service;
use App\Contracts\AvaliacaoRepositoryInterface;

class AvaliacaoService extends Service
{

    public function __construct(AvaliacaoRepositoryInterface $avaliacaoRepositoryInterface)
    {
        $this->repository = $avaliacaoRepositoryInterface;

    }

	public function total()
	{
		return $this->repository->total();
	}

    public function getAvaliacaoUsuarioParaProfissional($avaliador,$user_id)
    {
    	$total = 0;
    	$nota  = $this->repository->getAvaliacaoUsuarioParaProfissional($avaliador,$user_id);
    	
    	if($nota)
    	{
    		$total = abs($nota);
    	}

    	return $total;
    }

    public function getAvaliacaoProfissional($user_id)
    {

    	$total = 0;
    	$nota  = $this->repository->getAvaliacaoProfissional($user_id);
    	
    	if($nota)
    	{
    		$total = round($nota,1);
    	}

    	return $total;

    }


} 