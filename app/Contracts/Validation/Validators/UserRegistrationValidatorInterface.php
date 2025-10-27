<?php

declare(strict_types=1);


namespace App\Contracts\Validation\Validators;

interface UserRegistrationValidatorInterface
{
    public function validate(array $data): void;
}