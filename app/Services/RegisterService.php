<?php

declare(strict_types=1);


namespace App\Services;

use App\Contracts\AuthServiceInterface;
use App\Contracts\Notifiers\UserRegisteredNotifierInterface;
use App\Contracts\Repositories\UserLogRepositoryInterface;
use App\Contracts\Services\Mail\MailTemplateServiceInterface;
use App\Contracts\Services\Mail\QueueMailServiceInterface;
use App\Contracts\Services\RegisterServiceInterface;
use App\Contracts\Services\UserCreatorServiceInterface;
use App\Contracts\Validation\Validators\UserRegistrationValidatorInterface;
use App\Models\User;

class RegisterService implements RegisterServiceInterface
{
    public function __construct(
        private readonly UserRegistrationValidatorInterface $validator,
        private readonly UserCreatorServiceInterface $userCreator,
        private readonly UserRegisteredNotifierInterface $notifier,
        private readonly AuthServiceInterface $authProvider,
    ) {}

    public function registerUser(array $data): User
    {
        $this->validator->validate($data);

        $user = $this->userCreator->createUser($data);

        $this->notifier->notify($user);

        $this->authProvider->setUser($user);

        return $user;
    }
}