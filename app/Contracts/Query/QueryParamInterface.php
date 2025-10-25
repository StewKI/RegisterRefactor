<?php

declare(strict_types=1);


namespace App\Contracts\Query;

use App\Enums\Query\ParamType;

interface QueryParamInterface
{
    public function isBindable(): bool;
    public function getValue(): mixed;
    public function getType(): ParamType;
}