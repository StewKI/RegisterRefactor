<?php

declare(strict_types=1);


namespace App\Validation\Rules;

use App\Contracts\Validation\RuleInterface;
use App\Exceptions\ValidationException;

class EmailFormatRule implements RuleInterface
{
    public function __construct(
        private readonly string $emailField,
    ) {}

    public function validate(array $data): void
    {
        $email = $data[$this->emailField];

        if (! $this->isValidEmail($email)) {
            throw new ValidationException("email_format");
        }
    }

    private function isValidEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
}