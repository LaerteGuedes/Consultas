<?php


namespace App\Repositories;


use App\Contracts\ConsultaRepositoryInterface;
use App\Repository;
use App\Consulta;
use App\Agenda;
use App\Aviso;
use Illuminate\Support\Facades\DB;


class ConsultaRepository extends Repository implements ConsultaRepositoryInterface
{
    protected $agenda;
    protected $avisoRepositoy;

    public function __construct(Consulta $consulta,
                                Agenda $agenda,
                                Aviso $aviso)
    {
        $this->model  = $consulta;
        $this->agenda = $agenda;
        $this->aviso  = $aviso;
    }

    public function formatDataConsulta($consultas)
    {
        $data = [];

        foreach($consultas as $consulta)
        {
            $obj = new \stdClass();
            $obj->id = $consulta->id;
            $obj->user_id = $consulta->user_id;
            $obj->profissional_id = $consulta->profissional_id;
            $obj->localidade_id = $consulta->localidade_id;
            $obj->data_agenda = $consulta->data_agenda;
            $obj->horario_agenda = $consulta->horario_agenda;
            $obj->pessoal = $consulta->pessoal;
            $obj->outro = $consulta->outro;
            $obj->nota = $consulta->nota;
            $obj->status = $consulta->status;
            $obj->paciente = $consulta->user->name . ' ' . $consulta->user->lastname;
            $obj->profissional = $consulta->profissional->name . ' ' . $consulta->profissional->lastname;
            $obj->profissao = $consulta->profissional->especialidade->especialidade->nome;
            if($consulta->profissional->ramos()->count())
            {
                foreach($consulta->profissional->ramos as $ramo)
                {
                    $ramos[] =  $ramo->ramo->nome;
                }

                $obj->profissional_ramo = implode(', ',$ramos);
            }else
            {
                $obj->profissional_ramo = '';
            }
            $obj->logradouro =  $consulta->localidade->logradouro;
            $obj->numero =  $consulta->localidade->numero;
            $obj->complemento = $consulta->localidade->complemento;
            $obj->bairro =  $consulta->localidade->bairro->nome;
            $obj->cep = $consulta->localidade->cep;
            $obj->cidade = $consulta->localidade->cidade->nome;
            $obj->uf = $consulta->localidade->uf;

            $data[$consulta->data_agenda][] = $obj;

            unset($obj);
        }

        return $data;
    }

    public function listarConsultasByProfissional($id,$data)
    {
        $res =  [];

        $consultas =  $this->model->where('profissional_id',$id)
            ->where(\DB::raw("month(data_agenda)"),$data['mes'])
            ->where(\DB::raw("year(data_agenda)"),$data['ano'])
            ->orderBy('data_agenda','asc')
            ->get();

        if($consultas->count())
        {
            $res = $this->formatDataConsulta($consultas);
        }

        //dd($res);  

        return $res;
    }

    public function confirmarConsulta($data)
    {

        $consulta = $this->find($data['consulta_id']);

        if($data['resposta']=='sim')
        {
            $data['status'] = 'CONFIRMADA';
            $aviso = [
                'tipo' => 'SUCESSO',
                'nota' => 'consulta confirmada com sucesso',
                'consulta_id' => $data['consulta_id'],
                'profissional_id' => $consulta->profissional_id,
                'cliente_id' => $consulta->user_id
            ];

        }elseif($data['resposta']=='nao')
        {
            $data['status'] = 'CANCELADA';
            $aviso = [
                'tipo' => 'ERROR',
                'nota' => 'consulta cancelada',
                'consulta_id' => $data['consulta_id'],
                'profissional_id' => $consulta->profissional_id,
                'cliente_id' => $consulta->user_id
            ];
        }

        $this->aviso->create($aviso);

        return $this->update($data['consulta_id'] , $data );
    }

    public function realizarConsulta($data)
    {

        $data['status'] = 'REALIZADA';

        return $this->update($data['consulta_id'],$data);
    }

    public function listarConsultasHistoricoByUser($id)
    {
        return $this->model->where('user_id',$id)
            ->where('status','<>','AGUARDANDO')
            ->orderBy('data_agenda','desc')
            ->get();
    }

    public function listarConsultasHistoricoByUserWithProfissional($id)
    {
        return DB::table('consultas')
            ->join('users', 'consultas.profissional_id', '=', 'users.id')
            ->where('user_id', $id)
            ->where('status', '<>', 'AGUARDANDO')
            ->where('data_agenda', '>', date('Y-m-d'))
            ->orderBy('data_agenda','desc')
            ->get();
    }

    public function countAgendadas()
    {
        return $this->model->where('status', 'AGUARDANDO')->orWhere('status', 'CONFIRMADA')->count();
    }

    public function countRealizadas()
    {
        return $this->model->where('status', 'REALIZADA')->count();
    }

    public function countCanceladas()
    {
        return $this->model->where('status', 'CANCELADA')->count();
    }

    public function listarConsultasFuturasByUser($id)
    {
        return $this->model->where('user_id',$id)
            ->where('status','AGUARDANDO')
            ->where('data_agenda','>',date('Y-m-d'))
            ->orderBy('data_agenda','asc')
            ->get();
    }

    public function listarConsultasFuturasByUserWithProfissional($id)
    {
        return DB::table('consultas')
            ->join('users', 'consultas.profissional_id', '=', 'users.id')
            ->where('user_id', $id)
            ->where('status', 'AGUARDANDO')
            ->where('data_agenda', '>', date('Y-m-d'))
            ->orderBy('data_agenda','asc')
            ->get();
    }

    public function listarConsultasDatasFuturas($id)
    {
        return $this->model->where('user_id',$id)->select('data_agenda')
            ->where('status','AGUARDANDO')
            ->where('data_agenda','>',date('Y-m-d'))
            ->groupBy('data_agenda')
            ->get();
    }

    public function listarConsultasDatasHistorico($id)
    {
        return $this->model->where('user_id',$id)->select('data_agenda')
            ->where('status', '<>' ,'AGUARDANDO')
            ->where('data_agenda','<',date('Y-m-d'))
            ->groupBy('data_agenda')
            ->get();
    }



    public function getTotalConsultasFuturasByUser($id)
    {
        return $this->model->where('profissional_id',$id)
            ->where('status','AGUARDANDO')
            ->where('data_agenda','>',date('Y-m-d'))
            ->orderBy('data_agenda','asc')
            ->count();
    }

    public function listarConsultasHistoricoByUserAndDate($id, $data_agenda)
    {
        return DB::table('consultas')
            ->select('users.id as profissional_id', 'users.cid', 'users.thumbnail', 'consultas.data_agenda',
                'consultas.status', 'consultas.horario_agenda', 'users.name', 'users.lastname')
            ->join('users', 'consultas.profissional_id', '=', 'users.id')
            ->where('user_id', $id)
            ->where('data_agenda', $data_agenda)
            ->where('status', '<>', 'AGUARDANDO')
            ->where('data_agenda', '>', date('Y-m-d'))
            ->orderBy('data_agenda','desc')
            ->get();
    }

    public function listarConsultasFuturasByUserAndDate($id, $data_agenda)
    {
        return DB::table('consultas')
            ->select('users.id as profissional_id', 'users.cid', 'users.thumbnail', 'consultas.data_agenda',
                'consultas.status', 'consultas.horario_agenda', 'users.name', 'users.lastname')
            ->join('users', 'consultas.profissional_id', '=', 'users.id')
            ->where('user_id', $id)
            ->where('data_agenda', $data_agenda)
            ->where('status', 'AGUARDANDO')
            ->where('data_agenda', '>', date('Y-m-d'))
            ->orderBy('data_agenda','asc')
            ->get();
    }

    public function checkIfAgendado($data)
    {
        return $this->model->where(function($query)use($data){

            $query->where('profissional_id', $data['profissional_id'] );
            $query->where('localidade_id'  , $data['localidade_id']   );
            $query->where('data_agenda'    , $data['data_agenda']     );
            $query->where('horario_agenda' , $data['horario_agenda']  );

        })->count();
    }


    public function listAllForCalendarByUser($id)
    {
        $data = [];
        $agendas = $this->agenda->where('user_id',$id)->orderBy('data_agenda','desc')->orderBy('horario_agenda','desc')->get();

        if($agendas)
        {
            foreach($agendas as $agenda)
            {
                $consulta = $agenda->consultas()->first();
                if($consulta){
                    $data[] = [

                        'agenda_id'   => $agenda->id,
                        'consulta_id' => $consulta->id,
                        'status'      => $consulta->listStatus()[$consulta->status],
                        'pessoal'     => $consulta->pessoal == 1 ? 'sim':'não, ' . $consulta->outro,
                        'cliente'     => $consulta->user->name . ' ' . $consulta->user->lastname,
                        'date'        => $agenda->data_agenda,
                        'local'       => sprintf("%s %s, %s, %s-%s",$agenda->localidade->logradouro,
                            $agenda->localidade->numero,
                            $agenda->localidade->bairro->nome,
                            $agenda->localidade->cidade->nome,
                            $agenda->localidade->uf),
                        'title'       => date("d/m/Y",strtotime($agenda->data_agenda)) . ' - ' . date("H:i",strtotime($agenda->horario_agenda))

                    ];
                }

            }
        }

        return $data;
    }
} 