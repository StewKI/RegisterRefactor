<?php

declare(strict_types=1);


namespace App\Models;

use DateTime;

class UserLog
{
    public function __construct(
        private readonly int $id,
        private string $action,
        private int $userId,
        private DateTime $logTime,
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function setAction(string $action): UserLog
    {
        $this->action = $action;

        return $this;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): UserLog
    {
        $this->userId = $userId;

        return $this;
    }

    public function getLogTime(): DateTime
    {
        return $this->logTime;
    }

    public function setLogTime(DateTime $logTime): UserLog
    {
        $this->logTime = $logTime;

        return $this;
    }


}