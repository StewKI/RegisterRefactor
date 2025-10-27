<?php

declare(strict_types=1);


namespace App\Services;

use App\Contracts\Services\HashingServiceInterface;

class NativeHashingService implements HashingServiceInterface
{
    const ALGORITHM = PASSWORD_BCRYPT;
    const COST = PASSWORD_BCRYPT_DEFAULT_COST;

    public function hash(string $password): string
    {
        return password_hash($password, self::ALGORITHM, ['cost' => self::COST]);
    }

    public function check(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }
}