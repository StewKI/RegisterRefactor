<?php

declare(strict_types=1);


namespace App\Validation\Rules;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Contracts\Validation\RuleInterface;
use App\Exceptions\ValidationException;

class EmailNotTakenRule implements RuleInterface
{
    public function __construct(
        private readonly string $emailField,
        private readonly UserRepositoryInterface $userRepository,
    ) {}

    public function validate(array $data): void
    {
        if ($this->checkEmailExists($data[$this->emailField])) {
            throw new ValidationException("email_taken");
        }
    }

    public function checkEmailExists(string $email): bool
    {
        return $this->userRepository->emailExists($email);
    }


}