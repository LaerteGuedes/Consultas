<?php 

namespace App\Contracts;

interface RepositoryInterface
{

	public function find($id , $columns = ['*']);

	public function findBy($field,$value,$columns = ['*']);

	public function all($columns = ['*'] );

	public function paginate($perpage , $columns = ['*']);

	public function create(array $data);

	public function update($id,array $data);

	public function destroy($id);

}