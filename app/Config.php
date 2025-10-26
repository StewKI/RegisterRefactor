<?php

declare(strict_types=1);


namespace App;

/**
 * @property-read ?array $db
 * @property-read ?array $mail
 */
class Config
{
    private array $config = [];

    public function __construct(array $env)
    {
        $this->config = [
            'db'   => [
                'host'     => $env['DB_HOST'],
                'user'     => $env['DB_USER'],
                'pass'     => $env['DB_PASS'],
                'database' => $env['DB_DATABASE'],
                'driver'   => $env['DB_DRIVER'] ?? 'mysql',
            ],
            'mail' => [
                'host'        => $env['MAIL_HOST'],
                'smtp_auth'   => $env['MAIL_SMTP'] === "true",
                'username'    => $env['MAIL_USERNAME'],
                'password'    => $env['MAIL_PASSWORD'],
                'smtp_secure' => $env['MAIL_SMTP_SECURE'],
                'port'        => $env['MAIL_PORT'],
            ],
        ];
    }

    public function __get(string $name)
    {
        return $this->config[$name] ?? null;
    }
}