<?php

declare(strict_types=1);


namespace App\Contracts\Validation;

use App\Exceptions\ValidationException;

interface RuleInterface
{
    /**
     * @throws ValidationException
     */
    public function validate(array $data): void;
}