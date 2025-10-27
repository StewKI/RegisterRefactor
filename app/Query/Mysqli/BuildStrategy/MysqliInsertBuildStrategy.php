<?php

declare(strict_types=1);


namespace App\Query\Mysqli\BuildStrategy;

use App\Contracts\Query\BuildStrategy\InsertBuildStrategyInterface;
use App\Contracts\Query\QueryInterface;
use App\Contracts\Query\QueryParamInterface;
use App\Query\Mysqli\MysqliParam;
use App\Query\Mysqli\MysqliQuery;
use App\Query\Mysqli\Traits\BindingParamsTrait;
use App\Query\Mysqli\Traits\QuotingNamesTrait;
use App\Query\QueryState\ValuesState;
use mysqli;

class MysqliInsertBuildStrategy implements InsertBuildStrategyInterface
{
    use BindingParamsTrait;
    use QuotingNamesTrait;

    public function __construct(private readonly mysqli $mysqli) {}

    /**
     * @param ValuesState[] $values
     */
    public function build(
        string $table,
        array $fields,
        array $values,
    ): QueryInterface {
        $stringStmt = $this->getStatementString($table, $fields, $values);
        $stmt       = $this->mysqli->prepare($stringStmt);

        $params = $this->getBindableParams($values);

        $this->bindParams($stmt, $params);

        return new MysqliQuery($stmt);
    }

    private function getStatementString(
        string $table,
        array $fields,
        array $values,
    ): string {
        return $this->getInsertString($table, $fields) . ' '
               . $this->getAllValuesString($values);
    }

    private function getInsertString(string $table, array $fields): string
    {
        $fields = $this->quoteMultiple($fields);

        $fieldsString = implode(', ', $fields);

        $table = $this->quoteName($table);

        return 'INSERT INTO ' . $table . ' (' . $fieldsString . ') VALUES ';
    }

    /**
     * @param ValuesState[] $valueStates
     */
    private function getAllValuesString(array $valueStates): string
    {
        $valuesStrings = array_map(
            fn(ValuesState $valuesState)
                => $this->getValuesString(
                $valuesState,
            ),
            $valueStates,
        );

        return implode(', ', $valuesStrings);
    }

    private function getValuesString(ValuesState $valuesState): string
    {
        $valuesStrings = array_map(
            fn(QueryParamInterface $param) => MysqliParam::toString($param),
            $valuesState->values,
        );

        $str = implode(', ', $valuesStrings);

        return "($str)";
    }

}