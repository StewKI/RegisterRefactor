<?php

declare(strict_types=1);


namespace App\Views;

use App\Contracts\ViewInterface;

class Redirect implements ViewInterface
{
    private function __construct(
        private readonly string $uri,
    )
    {}

    public static function to(string $uri): static
    {
        return new static($uri);
    }

    public function render(): string
    {
        header('Location: ' . $this->uri, response_code: 302);

        return '';
    }
}