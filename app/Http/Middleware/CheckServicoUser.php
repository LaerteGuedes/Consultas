<?php

namespace App\Http\Middleware;

use Closure;

use App\Contracts\ServicoRepositoryInterface;
use App\Services\MessageService;


class CheckServicoUser
{
    protected $servicoRepository;
    protected $messageService;

    public function __construct(ServicoRepositoryInterface $servicoRepositoryInterface,MessageService $messageService)
    {
        $this->servicoRepository = $servicoRepositoryInterface;
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
            return redirect()->route('servicos')->withErrors([$this->messageService->getMessage('error.not.user')]);
        }
        return $next($request);
    }

    protected function check($request)
    {
        $id      = $request->route()->getParameter('id');
        $user_id = $request->user()->id;

        return $this->servicoRepository->checkUserHasItem($user_id,$id);
    }
}
