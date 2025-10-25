<?php

declare(strict_types=1);


namespace App\Query;

use App\Contracts\Query\Builder\SelectQueryBuilderInterface;
use App\Contracts\Query\BuildStrategy\SelectBuildStrategyInterface;
use App\Contracts\Query\QueryInterface;
use App\Contracts\Query\QueryParamInterface;
use App\Enums\Query\Operator;
use App\Enums\Query\Order;
use App\Query\QueryState\LimitState;
use App\Query\QueryState\OrderByState;
use App\Query\QueryState\WhereState;

class SelectQueryBuilder implements SelectQueryBuilderInterface
{
    private ?WhereState $whereState = null;
    private ?OrderByState $orderByState = null;
    private ?LimitState $limitState = null;

    public function __construct(
        private readonly SelectBuildStrategyInterface $buildStrategy,
        private readonly string $table,
        private readonly array $fields,
    ) {}

    public function build(): QueryInterface
    {
        return $this->buildStrategy->build(
            $this->table,
            $this->fields,
            $this->whereState,
            $this->orderByState,
            $this->limitState,
        );
    }

    public function where(
        string $field,
        QueryParamInterface $param,
        Operator $operator = Operator::EQUAL,
    ): SelectQueryBuilderInterface {
        $this->whereState = new WhereState($field, $param, $operator);

        return $this;
    }

    public function orderBy(
        string $field,
        Order $order,
    ): SelectQueryBuilderInterface {
        $this->orderByState = new OrderByState($field, $order);

        return $this;
    }

    public function limit(int $limit): SelectQueryBuilderInterface
    {
        $this->limitState = new LimitState($limit);

        return $this;
    }
}