<?php

declare(strict_types=1);


namespace App\Services;

use App\Contracts\AuthProviderInterface;
use App\Contracts\Repositories\UserLogRepositoryInterface;
use App\Contracts\Repositories\UserRepositoryInterface;
use App\Contracts\Services\Mail\MailTemplateServiceInterface;
use App\Contracts\Services\Mail\QueueMailServiceInterface;
use App\Contracts\Services\RegisterServiceInterface;
use App\Contracts\Validation\Validators\UserRegistrationValidatorInterface;
use App\Models\User;

class RegisterService implements RegisterServiceInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly QueueMailServiceInterface $queueMailService,
        private readonly UserLogRepositoryInterface $logRepository,
        private readonly AuthProviderInterface $authProvider,
        private readonly MailTemplateServiceInterface $mailTemplateService,
        private readonly UserRegistrationValidatorInterface $validator,
    ) {}

    public function registerUser(array $data): User
    {
        $this->validator->validate($data);

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