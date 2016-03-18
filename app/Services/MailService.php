<?php
namespace App\Services;

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

    public function sendConfirmacaoCadastro(User $user, $token)
    {
        Mail::send('emails.confirmacao-cadastro', ['user' => $user, 'token' => $token], function ($m) use ($user) {
            $m->to($user->email, $user->name)->subject('Confirmação de Cadastro');
        });
    }

    public function sendUserBoasVindas(User $user)
    {
        Mail::send('emails.boasvindasusuario', ['user' => $user], function ($m) use ($user) {
            $m->to($user->email, $user->name)->subject('Bem-vindo!');
        });
    }

    public function sendUserPeriodosTeste(User $user)
    {
        Mail::send('emails.periodo-testes', ['user' => $user], function ($m) use ($user) {
            $m->to($user->email, $user->name)->subject('Iniciando Período de Testes');
        });
    }

    public function sendProfissionalBoasVindas(User $user)
    {
        Mail::send('emails.boasvindasprofissional', ['user' => $user], function ($m) use ($user) {
            $m->from('noreply@sallus.net', 'Sallus - Secretaria Virtual');

            $m->to('laerteguedes8@gmail.com', $user->name)->subject('Bem-vindo!');
        });
    }

    public function agendamentoCliente(User $user, User $profissional, $data_agenda, $horario)
    {
        Mail::send('emails.agendamento-cliente', ['user' => $user, 'profissional' => $profissional, 'horario' => $horario, 'data_agenda' => $data_agenda], function ($m) use ($user){
            $m->to($user->email, $user->name)->subject('Agendamento de consulta');
        });
    }

    public function agendamentoProfissional(User $user, User $profissional, $data_agenda, $horario)
    {
        Mail::send('emails.agendamento-profissional', ['user' => $user, 'profissional' => $profissional, 'horario' => $horario, 'data_agenda' => $data_agenda], function ($m) use ($profissional){
            $m->to($profissional->email, $profissional->name)->subject('Agendamento de consulta');
        });
    }

    public function consultaCanceladaPorProfissional(User $user, User $profissional, $data_agenda)
    {
        Mail::send('emails.consulta-cancelada-prof', ['user' => $user, 'profissional' => $profissional, 'data_agenda' => $data_agenda], function ($m) use($user){
            $m->to('laerteguedes8@gmail.com', $user->name)->subject('Cancelamento de Consulta!');
        });
    }

    public function consultaCanceladaPorCliente(User $user, User $profissional, $data_agenda)
    {
        Mail::send('emails.consulta-cancelada-cliente', ['user' => $user, 'profissional' => $profissional, 'data_agenda' => $data_agenda], function ($m) use ($profissional){
            $m->to($profissional->email, $profissional->name)->subject('Cancelamento de Consulta!');
        });
    }

    public function notificacao($response)
    {
        Mail::send('emails.teste', ['response' => $response], function ($m) use ($response) {
            $m->to('laerteguedes8@gmail.com', 'Laerte')->subject('Notificacao!');
        });
    }

    public function sendNotificacaoExpiracaoTeste($user)
    {
        Mail::send('emails.expiracao-teste', ['user' => $user], function ($m) use ($user) {
            $m->to($user->email, $user->name)->subject('Expiração de período de testes');
        });
    }
    
}