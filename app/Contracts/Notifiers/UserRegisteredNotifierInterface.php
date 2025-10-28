<?php

declare(strict_types=1);


namespace App\Contracts\Notifiers;

use App\Models\User;

interface UserRegisteredNotifierInterface
{
    public function notify(User $user): void;
}