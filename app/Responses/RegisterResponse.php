<?php

declare(strict_types=1);


namespace App\Responses;

class RegisterResponse extends ResultResponse
{
    public static function successUser(int $userId): static
    {
        return static::success(["userId" => $userId]);
    }
}