<?php

declare(strict_types=1);


namespace App\Query\QueryState;

use App\Contracts\Query\HaveBindableParamsInterface;
use App\Contracts\Query\QueryParamInterface;

class SetState implements HaveBindableParamsInterface
{
    private array $setValues = [];

    public function __construct() {}

    public function setValue(string $field, QueryParamInterface $value): void
    {
        $this->setValues[$field] = $value;
    }

    public function isEmpty(): bool
    {
        return empty($this->setValues);
    }

    public function getValues(): array
    {
        return $this->setValues;
    }

    /**
     * @return QueryParamInterface[]
     */
    public function getBindableParams(): array
    {
        $params = [];

        /** @var QueryParamInterface $param */
        foreach ($this->setValues as $field => $param) {
            if ($param->isBindable()) {
                $params[] = $param;
            }
        }

        return $params;
    }
}