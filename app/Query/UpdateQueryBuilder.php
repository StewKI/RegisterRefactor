<?php

declare(strict_types=1);


namespace App\Query;

use App\Contracts\Query\Builder\UpdateQueryBuilderInterface;
use App\Contracts\Query\BuildStrategy\UpdateBuildStrategyInterface;
use App\Contracts\Query\QueryInterface;
use App\Contracts\Query\QueryParamInterface;
use App\Enums\Query\Operator;
use App\Exceptions\Query\QueryBuildingException;
use App\Query\QueryState\SetState;
use App\Query\QueryState\WhereState;

class UpdateQueryBuilder implements UpdateQueryBuilderInterface
{
    private SetState $setState;
    private ?WhereState $whereState = null;


    public function __construct(
        private readonly UpdateBuildStrategyInterface $buildStrategy,
        private readonly string $table,
    ) {
        $this->setState = new SetState();
    }

    public function build(): QueryInterface
    {
        $this->validateState();

        return $this->buildStrategy->build(
            $this->table,
            $this->setState,
            $this->whereState,
        );
    }

    public function set(
        string $field,
        QueryParamInterface $value,
    ): UpdateQueryBuilderInterface {
        $this->setState->setValue($field, $value);

        return $this;
    }

    public function where(
        string $field,
        QueryParamInterface $value,
        Operator $operator = Operator::EQUAL,
    ): UpdateQueryBuilderInterface {
        $this->whereState = new WhereState($field, $value, $operator);

        return $this;
    }

    private function validateState(): void
    {
        if ($this->whereState === null) {
            throw new QueryBuildingException(
                "Error! WHERE clause has not been set in UPDATE query!",
            );
        }

        if (count($this->setState->getValues()) === 0) {
            throw new QueryBuildingException(
                "Error! Nothing have been SET in UPDATE query!",
            );
        }
    }
}