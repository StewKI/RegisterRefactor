<?php

declare(strict_types=1);


namespace App\Contracts\Providers;

use App\DTOs\MailAddressData;

interface MailAddressProviderInterface
{
    public function getAddress(string $addressName): MailAddressData;
}