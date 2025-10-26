<?php

declare(strict_types=1);


namespace App\Contracts\Services\Mail;

use App\DTOs\MailData;
use App\Models\User;

interface MailTemplateServiceInterface
{
    public function getWelcomeMail(User $user): MailData;
}