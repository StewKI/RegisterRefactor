<?php

declare(strict_types=1);


namespace App\Services\ThirdParty;

use App\Contracts\Services\FraudDetectionServiceInterface;

class MaxMindFraudDetectionServiceMock implements FraudDetectionServiceInterface
{
    public function checkEmail(string $email): bool
    {
        return rand(1, 10) > 9; //10%
    }

    public function checkIp(string $ip): bool
    {
        return rand(1, 10) > 9; //10%
    }
}