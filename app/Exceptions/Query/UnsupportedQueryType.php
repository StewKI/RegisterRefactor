<?php

declare(strict_types=1);


namespace App\Exceptions\Query;


class UnsupportedQueryType extends \InvalidArgumentException
{
    public function __construct(string $type)
    {
        parent::__construct('Unsupported query type: ' . $type);
    }
}