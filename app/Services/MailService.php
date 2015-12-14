<?php
namespace App\Services;

use App\Custom\Debug;
use App\User;
use Illuminate\Support\Facades\Mail;

class MailService
{

    public function sendBoasVindas(User $user)
    {
        if ($user->cid){
            $this->sendProfissionalBoasVindas($user);
        }else{
            $this->sendUserBoasVindas($user);
        }
    }

    public function sendUserBoasVindas(User $user)
    {
        Mail::send('emails.boasvindasusuario', ['user' => $user], function ($m) use ($user) {
            $m->from('noreply@sallus.net', 'Sallus - Secretaria Virtual');

            $m->to($user->email, $user->name)->subject('Bem-vindo!');
        });
    }

    public function sendProfissionalBoasVindas(User $user)
    {
        Mail::send('emails.boasvindasprofissional', ['user' => $user], function ($m) use ($user) {
            $m->from('noreply@sallus.net', 'Sallus - Secretaria Virtual');

            $m->to($user->email, $user->name)->subject('Bem-vindo!');
        });
    }

    public function notificacao($response)
    {
        Mail::send('emails.teste', ['response' => $response], function ($m) use ($response) {
            $m->from('noreply@sallus.net', 'Sallus - Secretaria Virtual');

            $m->to('laerteguedes8@gmail.com', 'Laerte')->subject('Notificacao!');
        });
    }
    
}