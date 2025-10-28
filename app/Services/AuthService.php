<?php

declare(strict_types=1);


namespace App\Services;

use App\Contracts\AuthServiceInterface;
use App\Contracts\Repositories\UserRepositoryInterface;
use App\Contracts\SessionInterface;
use App\Models\User;

class AuthService implements AuthServiceInterface
{
    private const USER_KEY = 'userId';

    public function __construct(
        private readonly SessionInterface $session,
        private readonly UserRepositoryInterface $userRepository,
    ) {}

    public function setUser(User $user): void
    {
        $this->session->set(self::USER_KEY, $user->getId());
    }

    public function getUser(): ?User
    {
        $userId = $this->session->get(self::USER_KEY);

        if (! $userId) {
            return null;
        }

        return $this->userRepository->getUserById($userId);
    }
}