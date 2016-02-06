<?php 

namespace App;

use App\Contracts\ServiceInterface;
use App\Custom\Debug;

abstract class Service implements ServiceInterface
{
	protected $repository;

	public function find($id , $columns = ['*'])
	{
		return $this->repository->find($id,$columns);
	}

	public function findBy($field,$value,$column = ['*'])
	{
		return $this->repository->findBy($field, $value, $column);
	}

	public function all($columns=['*'])
	{
		return $this->repository->all($columns);
	}

	public function paginate($perpage=50,$columns=['*'])
	{
		return $this->repository->paginate($perpage,$columns);
	}

	public function create(array $data)
	{
		return $this->repository->create($data);
	}

	public function update($id,array $data)
	{
		return $this->repository->find($id)->update($data);
	}

	public function destroy($id)
	{
		Debug::dump($this->repository->find($id));
		return $this->repository->find($id)->delete();
	}
}