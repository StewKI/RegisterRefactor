<?php

namespace App\Query\Mysqli\Traits;

use App\Query\Mysqli\MysqliParam;
use App\Query\QueryState\WhereState;

trait MysqliWhereStringTrait
{
    public function getWhereString(?WhereState $whereState): ?string
    {
        if ( ! $whereState) {
            return null;
        }

        return 'WHERE ' . $whereState->field . ' '
               . $whereState->operator->value . ' ' . MysqliParam::toString(
                $whereState->param,
            );
    }
}