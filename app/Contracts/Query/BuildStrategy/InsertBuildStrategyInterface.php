<?php

declare(strict_types=1);


namespace App\Contracts\Query\BuildStrategy;

use App\Contracts\Query\QueryInterface;
use App\Contracts\Query\QueryParamInterface;
use App\Query\QueryState\ValuesState;

interface InsertBuildStrategyInterface
{
    /**
     * @param ValuesState[]  $values
     */
    public function build(string $table, array $fields, array $values): QueryInterface;

}