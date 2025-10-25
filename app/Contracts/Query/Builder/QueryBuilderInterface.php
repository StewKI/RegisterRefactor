<?php

declare(strict_types=1);


namespace App\Contracts\Query\Builder;

use App\Contracts\Query\QueryInterface;

interface QueryBuilderInterface
{
    public function build(): QueryInterface;
}