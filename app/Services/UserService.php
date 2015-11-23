<?php

namespace App\Services;

use App\Service;
use App\Contracts\UserRepositoryInterface;

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

    public function register(array $data)
    {

        if($this->repository->create($data))
        {

            $credentials = [

                'email'    => $data['email'],
                'password' => $data['password'],
                'active'   => 1

            ];

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


} 