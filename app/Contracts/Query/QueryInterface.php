<?php

declare(strict_types=1);


namespace App\Contracts\Query;

interface QueryInterface
{
    public function execute();
    public function lastInsertId(): int;
    public function fetchOne(): mixed;
    public function fetchAll(): array;
}