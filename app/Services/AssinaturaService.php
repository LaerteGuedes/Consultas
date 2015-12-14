<?php

namespace App\Services;

use App\Contracts\AssinaturaRepositoryInterface;
use App\Contracts\UserRepositoryInterface;
use App\Service;

class AssinaturaService extends Service
{
    protected $userRepository;
    protected $pagSeguroService;

    public function __construct(AssinaturaRepositoryInterface $assinaturaRepository,
                                UserRepositoryInterface $userRepository,
                                PagSeguroService $pagSeguroService)
    {
        $this->repository = $assinaturaRepository;
        $this->userRepository = $userRepository;
        $this->pagSeguroService = $pagSeguroService;
    }

    public function sendRequestPagSeguro($user_id, $assinatura_id)
    {
        $user = $this->userRepository->find($user_id);
        $assinatura = $this->repository->find($assinatura_id);

        return $this->pagSeguroService->sendAssinaturaRequest($user->name, $user->phone, $user->email, $assinatura->titulo, $assinatura->valor, $assinatura->id);
    }
}