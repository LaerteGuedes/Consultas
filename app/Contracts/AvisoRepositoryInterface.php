<?php


namespace App\Contracts;


interface AvisoRepositoryInterface {

	public function listarAvisosByCliente($id);
	public function listarAvisosByProfissional($id);
	public function getTotalAvisosPendentesByCliente($id);
	public function getTotalAvisosPendentesByProfissional($id);
	public function atualizaViewByCliente($id);
	public function atualizaViewByProfissional($id);
} 