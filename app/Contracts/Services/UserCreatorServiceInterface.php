<?php

declare(strict_types=1);


namespace App\Contracts\Services;

use App\Models\User;

interface UserCreatorServiceInterface
{
    public function createUser(array $data): User;
}