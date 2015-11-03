<?php

namespace App\Contracts;


interface UserRepositoryInterface {

    public function especialidade();

    public function pesquisar($data ,$perpage );

    public function atualizarViewProfissional($profissional_id);

    

} 