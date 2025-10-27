<?php

declare(strict_types=1);


namespace App\Validation\Rules;

use App\Contracts\Providers\IpProviderInterface;
use App\Contracts\Services\FraudDetectionServiceInterface;
use App\Contracts\Validation\RuleInterface;
use App\Exceptions\ValidationException;

class IpFraudDetectionRule implements RuleInterface
{
    public function __construct(
        private readonly IpProviderInterface $ipProvider,
        private readonly FraudDetectionServiceInterface $fraudDetectionService,
    ) {}

    public function validate(array $data): void
    {
        $ip = $this->ipProvider->getIp();

        $this->checkIp($ip);
    }

    private function checkIp($ip): void
    {
        if ($this->fraudDetectionService->checkIp($ip)) {
            throw new ValidationException("ip_fraud");
        }
    }
}