<?php

namespace App\Query\Mysqli\Traits;

use App\Query\Mysqli\MysqliParam;
use App\Query\QueryState\WhereState;

trait MysqliWhereStringTrait
{
    use QuotingNamesTrait;

    public function getWhereString(?WhereState $whereState): ?string
    {
        if ( ! $whereState) {
            return null;
        }

        $field = $this->quoteName($whereState->field);

        return 'WHERE ' . $field . ' '
               . $whereState->operator->value . ' ' . MysqliParam::toString(
                $whereState->param,
            );
    }
}