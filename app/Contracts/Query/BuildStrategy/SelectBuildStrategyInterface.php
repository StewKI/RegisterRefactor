<?php

declare(strict_types=1);


namespace App\Contracts\Query\BuildStrategy;

use App\Contracts\Query\QueryInterface;
use App\Query\QueryState\LimitState;
use App\Query\QueryState\OrderByState;
use App\Query\QueryState\WhereState;

interface SelectBuildStrategyInterface
{
    public function build(
        string $table,
        array $fields,
        ?WhereState $whereState,
        ?OrderByState $orderByState,
        ?LimitState $limitState
    ): QueryInterface;
}