<?php

declare(strict_types=1);


namespace App\Validation\Validators;

use App\Contracts\Validation\ValidatorInterface;
use App\Exceptions\ValidationException;

class RequiredValidator implements ValidatorInterface
{
    public function __construct(
        private readonly array $fields
    ) {}

    public function validate(array $data): void
    {
        foreach ($this->fields as $field) {
            $this->checkExist($data, $field);
        }
    }

    public function checkExist(array $data, mixed $field): void
    {
        if ( ! isset($data[$field])) {
            throw new ValidationException($field . '_required');
        }
    }
}