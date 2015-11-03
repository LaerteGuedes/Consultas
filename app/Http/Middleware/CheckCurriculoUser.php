<?php

namespace App\Http\Middleware;

use Closure;
use App\Contracts\CurriculoRepositoryInterface;
use App\Services\MessageService;

class CheckCurriculoUser
{


    protected $curriculoRepository;
    protected $messageService;

    public function __construct(CurriculoRepositoryInterface $curriculoRepositoryInterface,MessageService $messageService)
    {
        $this->curriculoRepository = $curriculoRepositoryInterface;
        $this->messageService = $messageService;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!$this->check($request)){
            return redirect()->route('curriculos')->withErrors([$this->messageService->getMessage('error.not.user')]);
        }
        return $next($request);
    }

    protected function check($request)
    {
        $id      = $request->route()->getParameter('id');
        $user_id = $request->user()->id;

        return $this->curriculoRepository->checkUserHasItem($user_id,$id);
    }
}
