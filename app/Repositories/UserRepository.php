<?php

namespace App\Repositories;

use App\Custom\Debug;
use App\Repository;
use App\Contracts\UserRepositoryInterface;
use App\Role;
use App\User;
use App\Avaliacao;
use Illuminate\Support\Facades\DB;


class UserRepository extends Repository implements UserRepositoryInterface
{
    protected $avaliacaoModel;

    public function __construct(User $user,Avaliacao $avaliacao)
    {
        $this->model = $user;
        $this->avaliacaoModel = $avaliacao;
    }

    public function atualizarViewProfissional($profissional_id)
    {

        $user = $this->model->find($profissional_id);

        return $user->update(['views'=> $user->views + 1]);

    }

    public function usuarioBusca($nome = null, $cidade = null)
    {
        if (!$nome && !$cidade){
            $query = $this->model->where('role_id', Role::CLIENTE);
        }
        if ($nome && !$cidade){
            $query = $this->model->where('name', $nome)->where('role_id', Role::CLIENTE);
        }
        if ($cidade && !$nome){
            $query = $this->model->join('localidades', 'users.id', '=', 'localidades.user_id')->join('cidades', 'localidades.cidade_id', '=', 'cidades.id')->where('cidades.id', $cidade)->where('role_id', Role::CLIENTE);
        }
        if ($cidade && $nome){
            $query = $this->model->join('localidades', 'users.id', '=', 'localidades.user_id')->join('cidades', 'localidades.cidade_id', '=', 'cidades.id')->where('cidades.id', $cidade)->where('role_id', Role::CLIENTE);
        }

        return $query->paginate(10);
    }

    public function usuariosClientes()
    {
        return $this->model->where('role_id', Role::CLIENTE)->paginate(10);
    }

    public function totalProfissional()
    {
        return $this->model->where('role_id', Role::PROFISSIONAL)->count();
    }

    public function totalProfissionalAtivo()
    {
        return $this->model->where('role_id', Role::PROFISSIONAL)->where('active', 1)->count();
    }

    public function totalProfissionalAssinaturaByStatus($status)
    {
        return DB::table('users')
                ->join('user_assinaturas', 'users.id', '=', 'user_assinaturas.user_id')
                ->where('user_assinaturas.assinatura_status', '=', $status)->count();

        $this->model->where('role_id', Role::PROFISSIONAL)->where('active', 1)->count();
    }

    public function assinaturasMensais()
    {
        return DB::table('users')
            ->join('user_assinaturas', 'users.id', '=', 'user_assinaturas.user_id')
            ->join('assinaturas', 'user_assinaturas.assinatura_id', '=', 'assinaturas.id')
            ->where('user_assinaturas.assinatura_status', '=', 'PERIODO_TESTES')
            ->select(DB::raw('count(assinaturas.id) as contagem'), DB::raw('SUM(assinaturas.valor) as soma'))
            ->first();
    }

    public function totalProfissionalInativo()
    {
        return $this->model->where('role_id', Role::PROFISSIONAL)->where('active', 0)->count();
    }

    public function total()
    {
        return $this->model->all()->count();
    }

    public function create(array $data)
    {
        $data['password'] = bcrypt($data['password']);

        if(isset($data['cid']))
        {
            $data['role_id'] = 3;

        }else{

            $data['role_id'] = 2;
        }

        return $this->model->create($data);
    }

    public function getByEmail($email)
    {
        return $this->model->where('email', $email)->first();
    }

    public function especialidade()
    {
        return $this->model->especialidade();
    }

    public function comentariosPorUsuario($user_id, $comentado){

        return $this->model->find($user_id)->comentadores()->where('comentado', '=', $comentado)->get();
    }

    public function pesquisar($data = array() , $perpage = 50)
    {

        return  \DB::table('users')
            ->join('user_especialidades','users.id','=','user_especialidades.user_id')
            ->join('especialidades','user_especialidades.especialidade_id','=','especialidades.id')
            ->leftJoin('user_assinaturas', 'user_assinaturas.user_id', '=', 'users.id')
            ->leftJoin('localidades','users.id','=','localidades.user_id')
            ->leftJoin('bairros', 'localidades.bairro_id', '=', 'bairros.id')
            ->leftJoin('user_ramos','users.id','=','user_ramos.user_id')
            ->leftJoin('ramos','user_ramos.ramo_id','=','ramos.id')
            ->where(function($query)use($data){

                $query->whereNull('users.deleted_at');
                $query->where('users.active','=',1);

                if(isset($data['especialidade_id']) && !empty($data['especialidade_id']))
                {
                    $query->where('especialidades.id' , $data['especialidade_id']);
                }
                if(isset($data['ramo_id']) && !empty($data['ramo_id']) )
                {
                    $query->where('ramos.id' , $data['ramo_id']);
                }
                if(isset($data['bairro_id']) && !empty($data['bairro_id']) )
                {
                    $query->where('localidades.bairro_id' , $data['bairro_id']);
                }
                if (isset($data['bairro_nome']) && !empty($data['bairro_nome']))
                {
                    $query->where("bairros.nome", 'LIKE' , '%'.$data['bairro_nome'].'%');
                }
                if(isset($data['cidade_id']) && !empty($data['cidade_id']))
                {
                    $query->where('localidades.cidade_id' , $data['cidade_id']);
                }
                if(isset($data['uf']) && !empty($data['uf']))
                {
                    $query->where('localidades.uf' , $data['uf']);
                }
                if(isset($data['name']) && !empty($data['name']))
                {
                    $query->where('users.name','like','%'. $data['name'].'%');
                    $query->orWhere('users.lastname','like','%'. $data['name'].'%');
                }
                $query->where('user_assinaturas.assinatura_status', '=', 'PERIODO_TESTES');
                $query->orWhere('user_assinaturas.assinatura_status', '=', 'APROVADO');
            })
            ->groupBy('users.id')
            ->select(\DB::raw('users.id,users.name, user_assinaturas.assinatura_status, users.lastname,users.thumbnail ,users.cid ,user_especialidades.especialidade_id,especialidades.nome as tipo,
localidades.uf,localidades.bairro_id,localidades.cidade_id,user_ramos.ramo_id,ramos.nome as ramo,
    (select count(*)  from comentarios where comentarios.comentado = users.id)
    
 as total_comentarios,
 (select round(avg(nota),1) from avaliacaos where avaliacaos.`user_id` = users.id ) as total_avaliacoes

'))
            ->paginate($perpage);
    }


    public function logarUsuarioApi($data)
    {
        $user =  $this->model->where('email',$data['email'])
            ->where('active',1)->first();

        if($user)
        {
            if( \Hash::check($data['password'],$user->password) )
            {
                return $user;
            }


        }

        return false;
    }

    public function registrarNovoUsuarioApi($data)
    {

        if($this->model->where('email',$data['email'])->count() > 0)
        {
            return false;
        }

        $data['password'] = bcrypt($data['password']);

        if(isset($data['cid']) && !empty($data['cid']))
        {
            $data['role_id'] = 3;

        }else{
            unset($data['cid']);
            $data['role_id'] = 2;
        }

        return $this->model->create($data);
    }

    public function editarUsuarioApi($params)
    {
        $user = User::find($params['id']);
        unset($params['id']);

        foreach ($params as $attr => $param){
            $user->$attr = $param;
        }

        $user->save();
    }

    public function deleteplano($user_id, $plano_id)
    {
        $user = $this->model->find($user_id);
        $user->planos()->detach($plano_id);
    }

    public function findPlanoParents($user_id){
        return $this->model->whereHas('planos', function($q) use ($user_id){
            $q->where('user_id', '=', $user_id);
        })->get();
    }

    public function listarDadosProfissionalApi($id)
    {
        $data     = [];
        $locais   = [];
        $homes    = [];
        $servicos = [];
        $curriculos =[];
        $comentarios =[];

        $user =  $this->model->find($id);
        $localidades = $user->localidades()->where('tipo','CONSULTORIO')->get();
        if($localidades)
        {
            foreach ($localidades as $local) {

                $locais[]=[

                    'id'          => $local->id,
                    'logradouro'  => $local->logradouro,
                    'numero'      => $local->numero,
                    'complemento' => $local->complemento,
                    'bairro'      => $local->bairro->nome,
                    'cep'         => $local->cep,
                    'cidade'      => $local->cidade->nome,
                    'uf'          => $local->uf,
                    'preco'       => $local->preco
                ];
            }
        }

        $homeCares = $user->localidades()->where('tipo','DOMICILIO')->get();
        if($homeCares)
        {
            foreach ($homeCares as $local) {

                $homes[]=[

                    'id'          => $local->id,
                    'logradouro'  => $local->logradouro,
                    'numero'      => $local->numero,
                    'complemento' => $local->complemento,
                    'bairro'      => $local->bairro->nome,
                    'cep'         => $local->cep,
                    'cidade'      => $local->cidade->nome,
                    'uf'          => $local->uf,
                    'preco'       => $local->preco
                ];
            }
        }

        if($user->curriculos()->count() > 0 )
        {
            foreach ($user->curriculos as $c) {

                $curriculos[] = $c;
            }
        }

        if( $user->servicos->count() > 0 )
        {
            foreach($user->servicos as $servico)
            {
                $servicos[] = $servico->toArray();
            }

        }

        if($user->comentarios->count() > 0)
        {
            foreach($user->comentarios as $comentario)
            {
                $star_votos = $this->avaliacaoModel->where('avaliador',$comentario->user_id)
                    ->where('user_id',$user->id)
                    ->avg('nota');

                $comentarios[]=[

                    'id'         => $comentario->id,
                    'descricao'  => $comentario->descricao,
                    'comentador' => $comentario->user->name .' ' . $comentario->user->lastname,
                    'star_votos' => $star_votos > 0 ? round($star_votos,1) : 0
                ];
            }
        }


        if($user)
        {
            $ramos = "";
            $total_comentarios = 0;
            $total_avaliacoes  = 0;

            if($user->ramos()->count())
            {
                foreach($user->ramos as $ramo)
                {
                    $ramos .= "," . $ramo->ramo->nome;
                }
            }
            if($user->comentarios()->count() > 0 )
            {
                $total_comentarios = $user->comentarios->count();
            }
            if($user->avaliados()->count() > 0 )
            {
                $total_avaliacoes = round($user->avaliados()->avg('nota'),1);
            }

            $data_user = [

                'id'            => $user->id,
                'role_id'       => $user->role_id,
                'name'          => $user->name,
                'lastname'      => $user->lastname,
                'phone'         => $user->phone,
                'email'         => $user->email,
                'cid'           => $user->cid,
                'active'        => $user->active,
                'views'         => $user->views,
                'thumbnail'     => $user->thumbnail,
                'especialidade' => $user->especialidade->especialidade->nome,
                'ramo'          => $ramos,
                'total_comentarios' => $total_comentarios,
                'total_avaliacoes' => $total_avaliacoes

            ];

            $data = [

                'user'     => $data_user,
                'locais'   => $locais,
                'homes'    => $homes,
                'servicos' => $servicos,
                'curriculos' => $curriculos,
                'comentarios' => $comentarios

            ];
        }

        return $data;

    }

    public function userNaoAtendePlanos($user_id)
    {
        $user = $this->model->find($user_id);
        $user->nao_atende_planos = 1;
        return $user->save();
    }

    public function updateAssinaturaAvaliacao($user_id, $params)
    {
        $user = $this->model->find($user_id);
        $user->assinatura_id = $params['assinatura_id'];
        $user->assinatura_status = $params['assinatura_status'];
        return $user->save();
    }

    public function saveUserAssinatura($user_id, $params)
    {
        $user = $this->model->find($user_id);
        $userAssinatura = $user->userAssinatura()->first();
        if (isset($userAssinatura->id)){
            $userAssinatura->update($params);
        }else{
            $params['expiracao'] = date('Y-m-d h:i:s', strtotime("+30 days"));
            $user->userAssinatura()->create($params);
        }
    }

} 







