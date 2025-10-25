<?php

declare(strict_types=1);


namespace App\Exceptions;

use RuntimeException;

class ValidationException extends RuntimeException
{
    public function __construct(
        public readonly string $error,
        string $message = "Validation failed",
    )
    {
        parent::__construct($message);
    }
}