<?php

declare(strict_types=1);


namespace App\Responses;

class RegisterResultResponse extends ResultResponse
{
    public static function successRegister(int $userId): static
    {
        return static::success(["userId" => $userId]);
    }
}