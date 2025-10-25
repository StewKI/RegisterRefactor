<?php

declare(strict_types=1);


namespace App\Query\QueryState;

use App\Enums\Query\Order;

class OrderByState
{
    public function __construct(
        public readonly string $field,
        public readonly Order $order,
    ) {}
}