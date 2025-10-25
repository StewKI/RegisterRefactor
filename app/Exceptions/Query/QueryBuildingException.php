<?php

declare(strict_types=1);


namespace App\Exceptions\Query;

class QueryBuildingException extends \RuntimeException
{
    public function __construct(
        string $message = "",
    ) {
        parent::__construct($message);
    }
}