<?php 

namespace App;

use App\Contracts\RepositoryInterface;

abstract class Repository implements RepositoryInterface
{
	protected $model;

	public function find($id , $columns = ['*'])
	{
		return $this->model->find($id,$columns);
	}

	public function findBy($field,$value,$column = ['*'])
	{
		return $this->model->where($field,'=',$value)->first($column);
	}

	public function all($columns=['*'])
	{
		return $this->model->all($columns);
	}

	public function paginate($perpage=50,$columns=['*'])
	{
		return $this->model->paginate($perpage,$columns);
	}

	public function create(array $data)
	{
		return $this->model->create($data);
	}

	public function update($id,array $data)
	{
		return $this->model->find($id)->update($data);
	}

	public function destroy($id)
	{
		return $this->model->find($id)->delete();
	}
}