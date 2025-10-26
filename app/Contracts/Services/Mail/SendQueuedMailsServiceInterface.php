<?php

declare(strict_types=1);


namespace App\Contracts\Services\Mail;

interface SendQueuedMailsServiceInterface
{
    public function sendQueuedMails(): void;
}