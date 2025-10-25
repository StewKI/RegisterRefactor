<?php

declare(strict_types=1);


namespace App\Contracts\Repositories;

use App\Models\UserLog;

interface UserLogRepositoryInterface
{
    public function createUserLog(string $action, int $userId): UserLog;
}