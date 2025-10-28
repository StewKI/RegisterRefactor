<?php

declare(strict_types=1);


namespace App\Models;

use App\DTOs\MailData;
use App\Enums\MailStatus;

class Mail
{
    public function __construct(
        private readonly int $id,
        private string $to,
        private string $from,
        private string $fromName,
        private string $subject,
        private string $body,
        private MailStatus $status,
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getTo(): string
    {
        return $this->to;
    }

    public function setTo(string $to): Mail
    {
        $this->to = $to;

        return $this;
    }

    public function getFrom(): string
    {
        return $this->from;
    }

    public function setFrom(string $from): Mail
    {
        $this->from = $from;

        return $this;
    }

    public function getFromName(): string
    {
        return $this->fromName;
    }

    public function setFromName(string $fromName): Mail
    {
        $this->fromName = $fromName;

        return $this;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): Mail
    {
        $this->subject = $subject;

        return $this;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function setBody(string $body): Mail
    {
        $this->body = $body;

        return $this;
    }

    public function getStatus(): MailStatus
    {
        return $this->status;
    }

    public function setStatus(MailStatus $status): Mail
    {
        $this->status = $status;

        return $this;
    }


}