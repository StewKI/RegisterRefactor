<?php

declare(strict_types=1);


namespace App\Validation\Rules;

use App\Contracts\Validation\RuleInterface;
use App\Exceptions\ValidationException;

class EqualsRule implements RuleInterface
{
    public function __construct(
        private readonly string $field1,
        private readonly string $field2,
        private readonly string $mismatchName = "field",
    ) {}

    public function validate(array $data): void
    {
        if ($data[$this->field1] !== $data[$this->field2]) {
            throw new ValidationException($this->mismatchName . "_mismatch");
        }
    }
}