<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Services\EstadoService;
use App\Services\UserService;
use App\Services\EspecialidadeService;


class PesquisaController extends Controller
{
	protected $estadoService;
	protected $userService;
	protected $especialidadeService;
	protected $comentarioService;

	public function __construct(EstadoService $estadoService,
								UserService $userService,
								EspecialidadeService $especialidadeService)
	{
		$this->estadoService = $estadoService;
		$this->userService   = $userService;
		$this->especialidadeService = $especialidadeService;
	}


	public function index(Request $request)
	{
		$users =  $this->userService->pesquisar($request->all());


		return view('pesquisa.index')->with([

				'users' => $users
			]);
	}

}
