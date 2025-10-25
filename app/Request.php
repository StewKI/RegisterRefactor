<?php

declare(strict_types=1);


namespace App;

class Request
{
    public function get(string $key, mixed $default = null): mixed
    {
        return $_GET[$key] ?? $default;
    }

    public function post(string $key, mixed $default = null): mixed
    {
        return $_POST[$key] ?? $default;
    }

    public function body(): array
    {
        return $_POST;
    }

    public function query(): array
    {
        return $_GET;
    }

    public function json(): array
    {
        $data = json_decode(file_get_contents('php://input'), true);
        return is_array($data) ? $data : [];
    }
}