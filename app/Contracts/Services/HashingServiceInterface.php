<?php

declare(strict_types=1);


namespace App\Contracts\Services;

interface HashingServiceInterface
{
    public function hash(string $password): string;

    public function check(string $password, string $hash): bool;
}