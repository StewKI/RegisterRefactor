<?php

declare(strict_types=1);


namespace App\Contracts\Query\Builder;

use App\Contracts\Query\QueryParamInterface;

interface InsertQueryBuilderInterface extends QueryBuilderInterface
{
    /**
     * @param QueryParamInterface[] $values
     */
    public function values(array $values): InsertQueryBuilderInterface;
}