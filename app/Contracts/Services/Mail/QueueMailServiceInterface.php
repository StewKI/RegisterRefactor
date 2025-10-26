<?php

declare(strict_types=1);


namespace App\Contracts\Services\Mail;

use App\DTOs\MailData;

interface QueueMailServiceInterface
{
    public function queueMail(MailData $mailData): void;
}