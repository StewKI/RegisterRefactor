<?php

declare(strict_types=1);


namespace App\Query\Mysqli\BuildStrategy;

use App\Contracts\Query\BuildStrategy\UpdateBuildStrategyInterface;
use App\Contracts\Query\QueryInterface;
use App\Contracts\Query\QueryParamInterface;
use App\Query\Mysqli\MysqliParam;
use App\Query\Mysqli\MysqliQuery;
use App\Query\Mysqli\Traits\BindingParamsTrait;
use App\Query\Mysqli\Traits\MysqliWhereStringTrait;
use App\Query\QueryState\SetState;
use App\Query\QueryState\WhereState;
use mysqli;

class MysqliUpdateBuildStrategy implements UpdateBuildStrategyInterface
{
    use BindingParamsTrait;
    use MysqliWhereStringTrait;

    public function __construct(private readonly mysqli $mysqli) {}

    public function build(
        string $table,
        SetState $setState,
        WhereState $whereState,
    ): QueryInterface
    {
        $stmtStr = $this->getStatementString($table, $setState, $whereState);
        $stmt = $this->mysqli->prepare($stmtStr);

        $params = $this->getBindableParams([$setState, $whereState]);
        $this->bindParams($stmt, $params);

        return new MysqliQuery($stmt);
    }

    private function getStatementString(
        string $table,
        SetState $setState,
        WhereState $whereState,
    ): string
    {
        $strings = [];

        $strings[] = $this->getUpdateString($table);
        $strings[] = $this->getSetString($setState);
        $strings[] = $this->getWhereString($whereState);

        return implode(' ', $strings);
    }

    private function getUpdateString(string $table) : string
    {
        return 'UPDATE ' . $table . ' SET';
    }

    private function getSetString(SetState $setState): string
    {
        $sets = [];
        /** @var string $field */
        /** @var QueryParamInterface $param */
        foreach ($setState->getValues() as $field => $param) {
            $sets[] = $field . ' = ' . MysqliParam::toString($param);
        }
        return implode(', ', $sets);
    }
}