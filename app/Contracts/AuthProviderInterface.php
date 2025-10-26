<?php

declare(strict_types=1);


namespace App\Contracts;

use App\Models\User;

interface AuthProviderInterface
{
    public function setUser(User $user): void;

    public function getUser(): User;
}