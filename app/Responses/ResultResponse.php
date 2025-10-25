<?php

declare(strict_types=1);

namespace App\Responses;

class ResultResponse
{
    private function __construct(private readonly array $payload)
    {}

    public static function success(array $data): static
    {
        return new static([
            "success" => true,
            ...$data,
        ]);
    }

    public static function failure (string $error): static
    {
        return new static([
            "success" => false,
            "error" => $error,
        ]);
    }

    public function getPayload(): array
    {
        return $this->payload;
    }
}