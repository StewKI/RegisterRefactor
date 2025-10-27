<?php

declare(strict_types=1);


namespace App\Validation\Rules;

use App\Contracts\Validation\RuleInterface;
use App\Exceptions\ValidationException;

class RequiredRule implements RuleInterface
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