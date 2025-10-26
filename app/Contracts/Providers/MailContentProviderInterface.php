<?php

declare(strict_types=1);


namespace App\Contracts\Providers;

use App\DTOs\MailContentData;

interface MailContentProviderInterface
{
    public function getContent(string $contentName): MailContentData;
}