<?php

declare(strict_types=1);


namespace App\Services;

use App\Contracts\AuthProviderInterface;
use App\Contracts\Repositories\UserLogRepositoryInterface;
use App\Contracts\Repositories\UserRepositoryInterface;
use App\Contracts\Services\Mail\MailTemplateServiceInterface;
use App\Contracts\Services\Mail\QueueMailServiceInterface;
use App\Contracts\Services\RegisterServiceInterface;
use App\Contracts\Validation\ValidatorInterface;
use App\Models\User;
use App\Validation\ValidationHelper;
use App\Validation\Validators\EmailFormatValidator;
use App\Validation\Validators\EmailNotTakenValidator;
use App\Validation\Validators\EqualsValidator;
use App\Validation\Validators\PasswordValidator;
use App\Validation\Validators\RequiredValidator;

class RegisterService implements RegisterServiceInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly QueueMailServiceInterface $queueMailService,
        private readonly UserLogRepositoryInterface $logRepository,
        private readonly AuthProviderInterface $authProvider,
        private readonly MailTemplateServiceInterface $mailTemplateService,
    ) {}

    public function registerUser(array $data): User
    {
        $this->validate($data);

        $user = $this->createUser($data);

        $this->onSuccess($user);

        return $user;
    }


    private function onSuccess(User $user): void
    {
        $this->queueWelcomeMail($user);
        $this->logRegistered($user);

        $this->authProvider->setUser($user);
    }

    public function createUser(array $data): User
    {
        return $this->userRepository->createUser(
            $data['email'],
            $data['password'],
        );
    }

    public function validate(array $data): void
    {
        ValidationHelper::validateAll($this->getValidators(), $data);
    }

    /**
     * @return ValidatorInterface[]
     */
    private function getValidators(): array
    {
        return [
            new RequiredValidator(["email", "password", "password2"]),
            new PasswordValidator(["password", "password2"]),
            new EmailFormatValidator('email'),
            new EqualsValidator("password", "password2", mismatchName: "password"),
            new EmailNotTakenValidator("email", $this->userRepository),
        ];
    }

    public function logRegistered(User $user): void
    {
        $this->logRepository->createUserLog("register", $user->getId());
    }

    public function queueWelcomeMail(User $user): void
    {
        $this->queueMailService->queueMail(
            $this->mailTemplateService->getWelcomeMail($user),
        );
    }

}