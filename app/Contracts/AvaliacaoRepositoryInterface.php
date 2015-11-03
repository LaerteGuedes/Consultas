<?php
/**
 * Created by PhpStorm.
 * User: hugomachado
 * Date: 07/09/15
 * Time: 21:14
 */

namespace App\Contracts;


interface AvaliacaoRepositoryInterface {

    public function getAvaliacaoUsuarioParaProfissional($avaliador,$user_id);
    public function getAvaliacaoProfissional($user_id);
    
} 