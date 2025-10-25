<?php

declare(strict_types=1);


namespace App\Contracts\Query\Builder;

use App\Contracts\Query\QueryParamInterface;
use App\Enums\Query\Operator;

interface UpdateQueryBuilderInterface extends QueryBuilderInterface
{
    public function set(
        string $field,
        QueryParamInterface $value,
    ): UpdateQueryBuilderInterface;

    public function where(
        string $field,
        QueryParamInterface $value,
        Operator $operator = Operator::EQUAL,
    ): UpdateQueryBuilderInterface;
}