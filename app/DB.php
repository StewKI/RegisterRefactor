<?php

declare(strict_types=1);


namespace App;

class DB
{
    private \mysqli $mysqli;

    public function __construct(array $config)
    {
        $this->mysqli = new \mysqli($config['host'], $config['user'], $config['pass'], $config['database']);
        $this->mysqli->set_charset('utf8mb4');
    }

    public function __destruct()
    {
        $this->mysqli->close();
    }

    public function getMysqli(): \mysqli
    {
        return $this->mysqli;
    }
}