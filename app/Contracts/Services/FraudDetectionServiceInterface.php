<?php

declare(strict_types=1);


namespace App\Contracts\Services;

interface FraudDetectionServiceInterface
{
    public function checkEmail(string $email): bool;

    public function checkIp(string $ip): bool;
}