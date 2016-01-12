<?php

namespace App\Services;

use App\Assinatura;
use App\Custom\Debug;
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

    public function usuarioBusca($nome = null, $cidade = null)
    {
        return $this->repository->usuarioBusca($nome, $cidade);
    }

    public function totalProfissionalAtivo()
    {
        return $this->repository->totalProfissionalAtivo();
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

    public function updateAssinaturaAvaliacao($user_id, $params)
    {
        $params['assinatura_status'] = Assinatura::AVALIACAO;
        return $this->repository->updateAssinaturaAvaliacao($user_id,$params);
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

    public function saveUserAssinatura($user_id, $params)
    {
        return $this->repository->saveUserAssinatura($user_id, $params);
    }

    public function userNaoAtendePlanos($user_id)
    {
        return $this->repository->userNaoAtendePlanos($user_id);
    }

} 