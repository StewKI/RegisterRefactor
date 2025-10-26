<?php

declare(strict_types=1);


namespace App\Contracts\Repositories;

use App\Models\User;

interface UserRepositoryInterface
{
    public function createUser(string $email, string $password): User;

    public function emailExists(string $email): bool;

    public function getUserById(int $userId): User;
}