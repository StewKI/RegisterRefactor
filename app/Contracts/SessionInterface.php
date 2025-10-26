<?php

declare(strict_types=1);


namespace App\Contracts;

interface SessionInterface
{
    public function startIfNeeded(): void;
    public function get(string $key): mixed;
    public function set(string $key, mixed $value): void;
    public function has(string $key): bool;
}