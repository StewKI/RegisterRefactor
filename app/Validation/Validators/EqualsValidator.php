<?php

declare(strict_types=1);


namespace App\Validation\Validators;

use App\Contracts\Validation\ValidatorInterface;
use App\Exceptions\ValidationException;

class EqualsValidator implements ValidatorInterface
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