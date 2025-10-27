<?php

declare(strict_types=1);


namespace App\Validation\Rules;

use App\Contracts\Services\FraudDetectionServiceInterface;
use App\Contracts\Validation\RuleInterface;
use App\Exceptions\ValidationException;

class EmailFraudDetectionRule implements RuleInterface
{
    public function __construct(
        private readonly string $emailField,
        private readonly FraudDetectionServiceInterface $fraudDetectionService,
    ) {}

    public function validate(array $data): void
    {
        $email = $this->getEmail($data);

        $this->checkEmail($email);
    }

    private function checkEmail(string $email): void
    {
        if ($this->fraudDetectionService->checkEmail($email)) {
            throw new ValidationException("email_fraud");
        }
    }

    public function getEmail($data)
    {
        return $data[$this->emailField];
    }
}