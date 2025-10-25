<?php

declare(strict_types=1);


namespace App\Query\QueryState;

use App\Contracts\Query\HaveBindableParamsInterface;
use App\Contracts\Query\QueryParamInterface;

class ValuesState implements HaveBindableParamsInterface
{
    /**
     * @param QueryParamInterface[] $values
     */
    public function __construct(
        public readonly array $values
    )
    {}

    /**
     * @return QueryParamInterface[]
     */
    public function getBindableParams(): array
    {
        $params = [];

        foreach ($this->values as $param) {
            if ($param->isBindable()) {
                $params[] = $param;
            }
        }

        return $params;
    }
}