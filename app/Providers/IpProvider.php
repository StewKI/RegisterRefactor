<?php

declare(strict_types=1);


namespace App\Providers;

use App\Contracts\Providers\IpProviderInterface;

class IpProvider implements IpProviderInterface
{

    public function getIp(): string
    {
        return $_SERVER['REMOTE_ADDR'] ?? "";
    }
}