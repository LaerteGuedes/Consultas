<?php

namespace App\Http\Controllers;

use App\Custom\Debug;
use App\Services\PlanoService;
use App\Services\UserService;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;

class PlanoController extends Controller
{

    protected $planoService;
    protected $userService;

    public function __construct(PlanoService $planoService, UserService $userService)
    {
        $this->planoService = $planoService;
        $this->userService = $userService;
    }

    public function index()
    {
        $planos = $this->planoService->paginateByUser(Auth::user()->id);

        return view("plano.index")->with("planos", $planos);
    }

    public function novo()
    {
        $planos = $this->planoService->findParents();

        return view("plano.novo")->with('planos', $planos);
    }

}
