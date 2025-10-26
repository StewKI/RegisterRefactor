<?php

declare(strict_types=1);


namespace App\Contracts\Repositories;

use App\DTOs\MailData;
use App\Enums\MailStatus;
use App\Models\Mail;

interface MailRepositoryInterface
{
    public function createMail(MailData $mailData, MailStatus $mailStatus): Mail;

    /**
     * @return Mail[]
     */
    public function getMailsByStatus(MailStatus $mailStatus): array;

    public function updateMailStatus(Mail $mail, MailStatus $newStatus): Mail;
}