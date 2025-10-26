<?php

declare(strict_types=1);


namespace App\Services\Mail;

use App\Contracts\Providers\MailAddressProviderInterface;
use App\Contracts\Providers\MailContentProviderInterface;
use App\Contracts\Services\Mail\MailTemplateServiceInterface;
use App\DTOs\MailAddressData;
use App\DTOs\MailContentData;
use App\DTOs\MailData;
use App\Models\User;

class MailTemplateService implements MailTemplateServiceInterface
{
    public function __construct(
        private readonly MailAddressProviderInterface $mailAddressProvider,
        private readonly MailContentProviderInterface $mailContentProvider,
    ) {}

    public function getWelcomeMail(User $user): MailData
    {
        $content = $this->mailContentProvider->getContent("welcome");
        $admin = $this->mailAddressProvider->getAddress("admin");

        return new MailData(
            $user->getEmail(),
            $content->subject,
            $content->body,
            $admin->email,
            $admin->name,
        );
    }
}