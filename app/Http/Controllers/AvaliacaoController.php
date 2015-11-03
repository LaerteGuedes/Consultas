<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\AvaliacaoService;

class AvaliacaoController extends Controller
{
    protected $avaliacaoService;

    public function __construct(AvaliacaoService $avaliacaoService)
    {
    	$this->avaliacaoService = $avaliacaoService;
    }

    public function avaliarProfissional(Request $request)
    {
    	$success = false;

    	if($this->avaliacaoService->create($request->all()))
    	{
    		$success = true;
    	}

    	return response()->json([

    				'success' => $success,
   
    		]);
    }
}
