<?php

declare(strict_types=1);


namespace App\Services;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Contracts\Services\HashingServiceInterface;
use App\Contracts\Services\UserCreatorServiceInterface;
use App\Models\User;

class UserCreatorService implements UserCreatorServiceInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $repository,
        //private readonly HashingServiceInterface $hashingService,
    ) {}

    public function createUser(array $data): User
    {
        [$email, $password] = $this->extract($data);

        //$password = $this->hashingService->hash($password);

        return $this->repository->createUser($email, $password);
    }

    private function extract(array $data): array
    {
        return [$data['email'], $data['password']];
    }
}