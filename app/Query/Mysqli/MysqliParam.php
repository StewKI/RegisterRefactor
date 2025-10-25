<?php

declare(strict_types=1);


namespace App\Query\Mysqli;

use App\Contracts\Query\QueryParamInterface;

class MysqliParam
{
    public static function toString(QueryParamInterface $queryParam): string
    {
        if ($queryParam->isBindable()) {
            return '?';
        }
        else {
            return (string) $queryParam->getValue();
        }
    }
}