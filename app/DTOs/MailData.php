<?php

declare(strict_types=1);


namespace App\DTOs;

use App\Enums\MailStatus;
use App\Models\Mail;

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

    public static function fromModel(Mail $mail): self
    {
        return new self(
            $mail->getTo(),
            $mail->getSubject(),
            $mail->getBody(),
            $mail->getFrom(),
            $mail->getFromName()
        );
    }

    public function toModel(int $id, MailStatus $status): Mail
    {
        return new Mail(
            $id,
            $this->to,
            $this->from,
            $this->fromName,
            $this->subject,
            $this->message,
            $status
        );
    }
}