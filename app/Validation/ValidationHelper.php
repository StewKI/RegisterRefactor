<?php

declare(strict_types=1);


namespace App\Validation;

use App\Contracts\Validation\ValidatorInterface;

class ValidationHelper
{
    /**
     * @var ValidatorInterface[]
     */
    private array $validators;

    public function register(ValidatorInterface $validator): void
    {
        $this->validators[] = $validator;
    }

    public function validate(array $data): void
    {
        foreach ($this->validators as $validator) {
            $validator->validate($data);
        }
    }
}