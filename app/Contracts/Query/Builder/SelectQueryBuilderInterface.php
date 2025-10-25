<?php

declare(strict_types=1);


namespace App\Contracts\Query\Builder;

use App\Contracts\Query\QueryParamInterface;
use App\Enums\Query\Operator;
use App\Enums\Query\Order;

interface SelectQueryBuilderInterface extends QueryBuilderInterface
{
    public function where(
        string $field,
        QueryParamInterface $param,
        Operator $operator = Operator::EQUAL,
    ): SelectQueryBuilderInterface;

    public function orderBy(
        string $field,
        Order $order,
    ): SelectQueryBuilderInterface;

    public function limit(int $limit): SelectQueryBuilderInterface;
}