<?php

declare(strict_types=1);


namespace App\Validation\Rules;

use App\Contracts\Validation\RuleInterface;
use App\Exceptions\ValidationException;

class PasswordRule implements RuleInterface
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