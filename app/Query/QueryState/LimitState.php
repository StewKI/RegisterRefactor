<?php

declare(strict_types=1);


namespace App\Query\QueryState;

class LimitState
{
    public function __construct(
        public readonly int $limit,
    ) {}
}