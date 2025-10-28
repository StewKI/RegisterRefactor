<?php

declare(strict_types=1);


namespace App\Services\Mail;

use App\Contracts\Repositories\MailRepositoryInterface;
use App\Contracts\Services\Mail\MailSenderServiceInterface;
use App\Contracts\Services\Mail\SendQueuedMailsServiceInterface;
use App\DTOs\MailData;
use App\Enums\MailStatus;
use App\Models\Mail;

class SendQueuedMailsService implements SendQueuedMailsServiceInterface
{
    public function __construct(
        private readonly MailRepositoryInterface $mailRepository,
        private readonly MailSenderServiceInterface $mailSenderService
    ) {}

    public function sendQueuedMails(): void
    {
        $mails = $this->mailRepository->getMailsByStatus(MailStatus::QUEUED);

        foreach ($mails as $mail) {
            $this->sendMail($mail);
        }
    }

    private function sendMail(Mail $mail): void
    {
        try
        {
            $this->mailSenderService->send(MailData::fromModel($mail));

            $this->mailRepository->updateMailStatus($mail, MailStatus::SENT);
        }
        catch (\Exception $e)
        {
            $this->mailRepository->updateMailStatus($mail, MailStatus::FAILED);
        }
    }
}