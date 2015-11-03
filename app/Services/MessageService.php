<?php

namespace App\Services;


class MessageService {


    protected $messages = [

        'error'          => "Não foi possível realizar a operação, tente novamente!",
        'success'        => "Operação realizada com sucesso!",
        'error.not.user' => "Você não tem permissão para acessar este item"

    ];

    public function getMessage($type)
    {
        return $this->messages[$type];
    }

} 