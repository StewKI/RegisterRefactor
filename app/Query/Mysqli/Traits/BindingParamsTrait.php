<?php

namespace App\Query\Mysqli\Traits;

use App\Contracts\Query\HaveBindableParamsInterface;
use App\Contracts\Query\QueryParamInterface;
use mysqli_stmt;

trait BindingParamsTrait
{
    /**
     * @param QueryParamInterface[] $queryParams
     */
    private function bindParams(mysqli_stmt &$stmt, array $queryParams): void
    {
        $types = '';
        $values = [];

        foreach ($queryParams as $param) {
            $types  .= $param->getType()->value;
            $values[] = $param->getValue();
        }

        $refs = [];
        foreach ($values as $key => $value) {
            $refs[$key] = &$values[$key];
        }

        array_unshift($refs, $types); // prepend type string

        call_user_func_array([$stmt, 'bind_param'], $refs);
    }

    /**
     * @param HaveBindableParamsInterface[] $values
     *
     * @return QueryParamInterface[]
     */
    private function getBindableParams(array $values): array
    {
        $params = [];

        foreach ($values as $key => $value) {
            $params = [...$params, ...$value->getBindableParams()];
        }

        return $params;
    }
}