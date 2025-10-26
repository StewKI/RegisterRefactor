<?php

declare(strict_types=1);


namespace App\DTOs;

class MailData
{
    public function __construct(
        public readonly string $to,
        public readonly string $subject,
        public readonly string $message,
        public readonly string $from,
        public readonly string $fromName
    )
    {}
}