<?php

declare(strict_types=1);


namespace App\Services\Mail;

use App\Contracts\Repositories\MailRepositoryInterface;
use App\Contracts\Services\Mail\QueueMailServiceInterface;
use App\DTOs\MailData;
use App\Enums\MailStatus;

class QueueMailService implements QueueMailServiceInterface
{
    public function __construct(
        private MailRepositoryInterface $mailRepository,
    ) {}

    public function queueMail(MailData $mailData): void
    {
        $this->mailRepository->createMail($mailData, MailStatus::QUEUED);
    }
}