<?php

namespace App\Services;

use App\Assinatura;
use App\Custom\Debug;
use App\Role;
use App\Service;
use App\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\Session;

class UserService extends Service
{
    public function __construct(UserRepositoryInterface $userRepositoryInterface)
    {
        $this->repository = $userRepositoryInterface;
    }


    public function deletePhoto($photo)
    {
        
        if($photo)
        {
            $explode = explode("/",$photo);
            $file = end($explode);
            $filepath =  public_path() . '/upload/perfil/'.  $file;

            if(file_exists($filepath)){
                 unlink($filepath);
            }
        }
       
    }

    public function usuariosClientes()
    {
        return $this->repository->usuariosClientes();
    }

    public function totalProfissional()
    {
        return $this->repository->totalProfissional();
    }

    public function assinaturasMensais()
    {
        return $this->repository->assinaturasMensais();
    }

    public function usuarioBusca($nome = null, $cidade = null)
    {
        return $this->repository->usuarioBusca($nome, $cidade);
    }

    public function totalProfissionalAtivo()
    {
        return $this->repository->totalProfissionalAtivo();
    }

    public function totalProfissionalAssinaturaByStatus($status)
    {
        return $this->repository->totalProfissionalAssinaturaByStatus($status);
    }

    public function totalProfissionalInativo()
    {
        return $this->repository->totalProfissionalInativo();
    }

    public function getByEmail($email)
    {
        return $this->repository->getByEmail($email);
    }

    public function total()
    {
        return $this->repository->total();
    }

    public function upload($request , $field)
    {
        $imageName = str_random(20) .'.'. $request->file($field)->getClientOriginalExtension();

        $request->file($field)->move(
            public_path() . '/upload/perfil/', $imageName
        );

        return asset('/upload/perfil/' . $imageName);
    }  

    public function atualizarViewProfissional($profissional_id)
    {
        return $this->repository->atualizarViewProfissional($profissional_id);
    }

    public function comentariosPorUsuario($user_id, $comentado)
    {
        return $this->repository->comentariosPorUsuario($user_id, $comentado);
    }

    public function pesquisar($data = array() , $perpage = 50)
    {
        return $this->repository->pesquisar($data , $perpage);
    }

    public function isProfissionalDisponivelAtDate($user_id, $date, $dia_semana)
    {

        $today = date('Y-m-d');

        if ($today == $date){
            $nowHour = date('H:m:s');
            $usuario = $this->repository->isProfissionalDisponivelToday($user_id, $date, $dia_semana, $nowHour);
        }else{
            $usuario = $this->repository->isProfissionalDisponivelAtDate($user_id, $date, $dia_semana);
        }

        if (isset($usuario->id)){
            if (!$usuario->quant_grade){
                return false;
            }
            if ($usuario->quant_grade > $usuario->quant_consultas){
                return true;
            }else{
                return false;
            }
        }

        return false;
    }

    public function updateAssinaturaAvaliacao($user_id, $params)
    {
        $params['assinatura_status'] = Assinatura::AVALIACAO;
        return $this->repository->updateAssinaturaAvaliacao($user_id,$params);
    }

    public function findByEmail($email)
    {
        return $this->repository->findByEmail($email);
    }

    public function findByEmailAndRole($email, $role_id)
    {
        return $this->repository->findByEmailAndRole($email, $role_id);
    }

    public function registerUserProfissionalAndCliente(array $data)
    {
        $dataCliente = $data;
        $dataProfissional = $data;

        unset($dataCliente['cid']);
        unset($dataCliente['especialidade_id']);

        $this->repository->create($dataCliente);

        if($this->repository->create($dataProfissional))
        {

            $credentials = [

                'email'    => $data['email'],
                'password' => $data['password'],
                'active'   => 1

            ];

            Session::flush();
            \Auth::attempt($credentials);
            return true;

        }

        return false;
    }

    public function ativaCadastroByEmail($email)
    {
        return $this->repository->ativaCadastroByEmail($email);
    }

    public function register(array $data)
    {
        if($this->repository->create($data))
        {

            $credentials = [

                'email'    => $data['email'],
                'password' => $data['password'],
                'active'   => 1

            ];

            Session::flush();
            \Auth::attempt($credentials);
            return true;

        }

        return false;

    }

    public function updatePerfil($id , $request )
    {
        $data = $request->all();
        
        $user = $this->repository->find($id);

        if($request->file('thumbnail'))
        {
            $this->deletePhoto($user->thumbnail);
            $data['thumbnail'] = $this->upload($request,'thumbnail');

        }

        if (isset($data['password'])){
            $data['password'] = bcrypt($data['password']);
        }

        if(isset($data['especialidade_id']) && !empty($data['especialidade_id']))
        {
            $especialidade_id = $data['especialidade_id'];

            $userEspecialidade = $this->find($id)->especialidade()->first();


            if($userEspecialidade){

                $userEspecialidade->delete();
                $this->repository->especialidade()->insert([
                    'user_id'          => $id,
                    'especialidade_id' => $especialidade_id
                ]);

            }else{

                $this->repository->especialidade()->insert([

                    'user_id'          => $id,
                    'especialidade_id' => $especialidade_id

                ]);

            }
        }

        return $this->repository->update($id,$data);
    }

    public function findPlanoParents($user_id){
        return $this->repository->findPlanoParents($user_id);
    }

    public function deleteplano($user_id, $plano_id)
    {
        $this->repository->deleteplano($user_id, $plano_id);
    }

    public function logarUsuarioApi($data)
    {
        return $this->repository->logarUsuarioApi($data);
    }

    public function editarUsuarioApi($params)
    {
        return $this->repository->editarUsuarioApi($params);
    }

    public function registrarNovoUsuarioApi($data)
    {
        return $this->repository->registrarNovoUsuarioApi($data);
    }

    public function listarDadosProfissionalApi($id)
    {
        return $this->repository->listarDadosProfissionalApi($id);
    }

    public function getProfissionalEtapa($id)
    {
        $profissional = $this->repository->getCompleteProfissional($id);

        if (isset($profissional->id)){
            if (!$profissional->localidade_id){
                return 'localidade';
            }

            if (!$profissional->grade_id){
                return 'grade';
            }

            if (!$profissional->plano_id && $profissional->nao_atende_planos == 0){
                return 'plano';
            }

            if (!$profissional->assinatura_id && !$profissional->assinatura_status){
                return 'assinatura';
            }

            if ($profissional->assinatura_id && $profissional->assinatura_status == 'AGUARDANDO'){
                return 'assinatura_aguardando';
            }

            if ($profissional->assinatura_id && $profissional->assinatura_status == 'SUSPENSO'){
                return 'assinatura_suspensa';
            }

            if ($profissional->assinatura_status == 'PERIODO_TESTES_SUSPENSO'){
                return 'assinatura_testes_suspensa';
            }
            return true;
        }

        return false;
    }

    public function saveUserAssinatura($user_id, $params)
    {
        return $this->repository->saveUserAssinatura($user_id, $params);
    }

    public function userNaoAtendePlanos($user_id)
    {
        return $this->repository->userNaoAtendePlanos($user_id);
    }

    public function checkEtapa($user_id)
    {
        $user = $this->repository->find($user_id);

        if ($user->role_id != Role::PROFISSIONAL){
            return false;
        }

        $localidadeCount = $user->localidades()->count();

        if (!$localidadeCount){
            return 'localidade';
        }

        $gradeCount = $user->grades()->count();

        if (!$gradeCount){
            return 'grade';
        }

        $plano = $user->planos()->first();

        if (!isset($plano->id)){
            return 'plano';
        }

        $assinatura = $user->userAssinatura()->first();

        if (!isset($assinatura->id)){
            return 'assinatura';
        }

        if ($assinatura->assinatura_status == 'AGUARDANDO'){
            return 'assinatura';
        }

        if ($assinatura->assinatura_status == 'SUSPENSO'){
            return 'assinatura';
        }

        if ($assinatura->assinatura_status == 'PERIODO_TESTES_SUSPENSO'){
            return 'assinatura';
        }

        return false;
    }

} 