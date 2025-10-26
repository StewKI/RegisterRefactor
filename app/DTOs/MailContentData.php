<?php

declare(strict_types=1);


namespace App\DTOs;

class MailContentData
{
    public function __construct(
        public readonly string $subject,
        public readonly string $body,
    )
    {}
}