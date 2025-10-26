<?php

declare(strict_types=1);


namespace App\Contracts\Services\Mail;

use App\DTOs\MailData;

interface MailSenderServiceInterface
{
    public function send(MailData $mailData): void;
}