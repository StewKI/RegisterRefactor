<?php

declare(strict_types=1);


namespace App\Services;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Contracts\Services\RegisterServiceInterface;
use App\Contracts\Validation\ValidatorInterface;
use App\Models\User;
use App\Validation\ValidationHelper;
use App\Validation\Validators\EmailNotTakenValidator;
use App\Validation\Validators\EqualsValidator;
use App\Validation\Validators\PasswordValidator;
use App\Validation\Validators\RequiredValidator;

class RegisterService implements RegisterServiceInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
    ) {}

    public function registerUser(array $data): User
    {
        ValidationHelper::validateAll($this->getValidators(), $data);

        $user = $this->userRepository->createUser($data['email'], $data['password']);

        $this->onSuccess($user);
        return $user;
    }

    private function onSuccess(User $user)
    {

    }


    /**
     * @return ValidatorInterface[]
     */
    private function getValidators(): array
    {
        return [
            new RequiredValidator(["email", "password", "password2"]),
            new PasswordValidator(["password", "password2"]),
            new EqualsValidator("password", "password2", "password"),
            new EmailNotTakenValidator("email", $this->userRepository),
        ];
    }
}