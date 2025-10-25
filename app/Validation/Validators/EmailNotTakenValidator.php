<?php

declare(strict_types=1);


namespace App\Validation\Validators;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Contracts\Validation\ValidatorInterface;
use App\Exceptions\ValidationException;

class EmailNotTakenValidator implements ValidatorInterface
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