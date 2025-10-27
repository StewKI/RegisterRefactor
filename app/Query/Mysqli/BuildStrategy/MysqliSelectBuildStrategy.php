<?php

declare(strict_types=1);


namespace App\Query\Mysqli\BuildStrategy;

use App\Contracts\Query\BuildStrategy\SelectBuildStrategyInterface;
use App\Contracts\Query\QueryInterface;
use App\Contracts\Query\QueryParamInterface;
use App\Query\Mysqli\MysqliQuery;
use App\Query\Mysqli\Traits\BindingParamsTrait;
use App\Query\Mysqli\Traits\MysqliWhereStringTrait;
use App\Query\Mysqli\Traits\QuotingNamesTrait;
use App\Query\QueryState\LimitState;
use App\Query\QueryState\OrderByState;
use App\Query\QueryState\WhereState;
use mysqli;

class MysqliSelectBuildStrategy implements SelectBuildStrategyInterface
{
    use BindingParamsTrait;
    use MysqliWhereStringTrait;

    public function __construct(
        private readonly mysqli $mysqli,
    ) {}

    public function build(
        string $table,
        array $fields,
        ?WhereState $whereState,
        ?OrderByState $orderByState,
        ?LimitState $limitState,
    ): QueryInterface {

        $stmtString = $this->getStringStatement($table, $fields, $whereState, $orderByState, $limitState);
        $stmt = $this->mysqli->prepare($stmtString);

        if ($whereState) {
            $params = $this->getBindableParams([$whereState]);
            $this->bindParams($stmt, $params);
        }

        return new MysqliQuery($stmt);
    }

    private function getStringStatement(
        string $table,
        array $fields,
        ?WhereState $whereState,
        ?OrderByState $orderByState,
        ?LimitState $limitState,
    ): string {
        $parts = [];

        $parts[] = $this->getSelectString($table, $fields);
        $parts[] = $this->getWhereString($whereState);
        $parts[] = $this->getOrderByString($orderByState);
        $parts[] = $this->getLimitString($limitState);

        $parts = array_filter($parts, fn ($part) => $part !== null);

        return implode(' ', $parts);
    }

    private function getSelectString(string $table, array $fields): string
    {
        $fields = $this->quoteMultiple($fields);
        $fieldsString = implode(',', $fields);

        $table = $this->quoteName($table);
        return 'SELECT ' . $fieldsString . ' FROM ' . $table;
    }

    private function getOrderByString(?OrderByState $orderByState): ?string
    {
        if ( ! $orderByState) {
            return null;
        }

        $field = $this->quoteName($orderByState->field);

        return 'ORDER BY ' . $field . ' ' . $orderByState->order->value;
    }

    private function getLimitString(?LimitState $limitState): ?string
    {
        if ( ! $limitState) {
            return null;
        }

        return 'LIMIT ' . $limitState->limit;
    }
}