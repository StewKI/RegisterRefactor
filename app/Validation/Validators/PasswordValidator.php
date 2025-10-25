<?php

declare(strict_types=1);


namespace App\Validation\Validators;

use App\Contracts\Validation\ValidatorInterface;
use App\Exceptions\ValidationException;

class PasswordValidator implements ValidatorInterface
{
    /**
     * @param string[] $passwordFields
     */
    public function __construct(private readonly array $passwordFields) {}

    public function validate(array $data): void
    {
        foreach ($this->passwordFields as $passwordField) {
            if (! $this->checkValidPassword($data[$passwordField])) {
                throw new ValidationException($passwordField);
            }
        }
    }

    private function checkValidPassword(string $password): bool
    {
        if (empty($password) || mb_strlen($password) < 8) {
            return false;
        }
        return true;
    }
}