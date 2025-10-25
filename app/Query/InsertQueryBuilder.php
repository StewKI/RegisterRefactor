<?php

declare(strict_types=1);


namespace App\Query;

use App\Contracts\Query\Builder\InsertQueryBuilderInterface;
use App\Contracts\Query\BuildStrategy\InsertBuildStrategyInterface;
use App\Contracts\Query\QueryInterface;
use App\Contracts\Query\QueryParamInterface;
use App\Query\QueryState\ValuesState;

class InsertQueryBuilder implements InsertQueryBuilderInterface
{

    /**
     * @var ValuesState[]
     */
    private array $values = [];

    public function __construct(
        private readonly InsertBuildStrategyInterface $buildStrategy,
        private readonly string $table,
        private readonly array $fields
    )
    {}

    /**
     * @param QueryParamInterface[] $values
     */
    public function values(array $values): InsertQueryBuilderInterface
    {
        $this->values[] = new ValuesState($values);

        return $this;
    }

    public function build(): QueryInterface
    {
        return $this->buildStrategy->build($this->table, $this->fields, $this->values);
    }
}