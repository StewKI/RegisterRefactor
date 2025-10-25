<?php

declare(strict_types=1);


namespace App\Contracts\Query\BuildStrategy;

use App\Contracts\Query\QueryInterface;
use App\Query\QueryState\SetState;
use App\Query\QueryState\WhereState;

interface UpdateBuildStrategyInterface
{
    public function build(
        string $table,
        SetState $setState,
        WhereState $whereState,
    ): QueryInterface;
}