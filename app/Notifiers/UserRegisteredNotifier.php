<?php

declare(strict_types=1);


namespace App\Notifiers;

use App\Contracts\Notifiers\UserRegisteredNotifierInterface;
use App\Contracts\Repositories\UserLogRepositoryInterface;
use App\Contracts\Services\Mail\MailTemplateServiceInterface;
use App\Contracts\Services\Mail\QueueMailServiceInterface;
use App\Models\User;

class UserRegisteredNotifier implements UserRegisteredNotifierInterface
{
    public function __construct(
        private readonly MailTemplateServiceInterface $mailTemplateService,
        private readonly QueueMailServiceInterface $queueMailService,
        private readonly UserLogRepositoryInterface $logRepository,
    ) {}

    public function notify(User $user): void
    {
        $this->logRegistered($user);
        $this->queueWelcomeMail($user);
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