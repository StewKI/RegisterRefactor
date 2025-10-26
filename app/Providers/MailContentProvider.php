<?php

declare(strict_types=1);


namespace App\Providers;

use App\Contracts\DataLoaderInterface;
use App\Contracts\Providers\MailContentProviderInterface;
use App\DTOs\MailContentData;

class MailContentProvider implements MailContentProviderInterface
{
    private const CONTENT_DATA_KEY = 'mail_contents';
    private array $data = [];

    public function __construct(
        DataLoaderInterface $dataLoader,
    ) {
        $this->data = $dataLoader->getData(self::CONTENT_DATA_KEY);
    }

    public function getContent(string $contentName): MailContentData
    {
        $data = $this->data[$contentName];
        return $this->mapData($data);
    }

    private function mapData(array $data): MailContentData
    {
        return new MailContentData(
            $data['subject'],
            $data['body'],
        );
    }
}