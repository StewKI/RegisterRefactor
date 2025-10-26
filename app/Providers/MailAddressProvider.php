<?php

declare(strict_types=1);


namespace App\Providers;

use App\Contracts\DataLoaderInterface;
use App\Contracts\Providers\MailAddressProviderInterface;
use App\DTOs\MailAddressData;

class MailAddressProvider implements MailAddressProviderInterface
{
    private const MAIL_ADDRESSES_KEY = 'mail_addresses';
    private array $mailAddressesData;

    public function __construct(
        DataLoaderInterface $dataLoader,
    ) {
        $this->mailAddressesData = $dataLoader->getData(self::MAIL_ADDRESSES_KEY);
    }

    public function getAddress(string $addressName): MailAddressData
    {
        $data = $this->mailAddressesData[$addressName];

        return $this->mapData($data);
    }

    private function mapData(array $data): MailAddressData
    {
        return new MailAddressData(
            $data['email'],
            $data['name'],
        );
    }
}