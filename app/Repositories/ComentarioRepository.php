<?php
/**
 * Created by PhpStorm.
 * User: hugomachado
 * Date: 29/08/15
 * Time: 23:45
 */

namespace App\Repositories;

use App\Repository;
use App\Contracts\ComentarioRepositoryInterface;
use App\Comentario;


class ComentarioRepository extends Repository implements ComentarioRepositoryInterface
{
    public function __construct(Comentario $comentario)
    {
        $this->model = $comentario;
    }

    public function getTotalComentarioProfissional($id)
    {
    	return $this->model->where('comentado',$id)
    					   ->count();
    }

} 