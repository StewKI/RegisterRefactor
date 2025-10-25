<?php

declare(strict_types=1);


namespace App\Query\QueryState;

use App\Contracts\Query\HaveBindableParamsInterface;
use App\Contracts\Query\QueryParamInterface;
use App\Enums\Query\Operator;

class WhereState implements HaveBindableParamsInterface
{
    public function __construct(
        public readonly string $field,
        public readonly QueryParamInterface $param,
        public readonly Operator $operator = Operator::EQUAL,
    )
    {}

    /**
     * @return QueryParamInterface[]
     */
    public function getBindableParams(): array
    {
        $params = [];

        if ($this->param->isBindable())
        {
            $params[] = $this->param;
        }

        return $params;
    }
}