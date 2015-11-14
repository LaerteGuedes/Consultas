<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\AvisoService;

class AvisoController extends Controller
{
   protected $avisoService;

   public function __construct(AvisoService $avisoService)
   {
   		$this->avisoService = $avisoService;
   }

   public function index()
   {

   		if(\Auth::user()->role->name =='Cliente')
   		{
   			$avisos = $this->avisoService->listarAvisosByCliente(\Auth::user()->id );
            $this->avisoService->atualizaViewByCliente( \Auth::user()->id  );
   		}else
   		{
			$avisos = $this->avisoService->listarAvisosByProfissional(\Auth::user()->id );
            $this->avisoService->atualizaViewByProfissional( \Auth::user()->id );
   		}

   		return view('aviso.index')->with([
   				'avisos'=> $avisos
   			]);
   }
}
