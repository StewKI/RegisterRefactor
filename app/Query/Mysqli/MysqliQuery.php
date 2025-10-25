<?php

declare(strict_types=1);


namespace App\Query\Mysqli;

use App\Contracts\Query\QueryInterface;
use mysqli_result;
use mysqli_stmt;
use RuntimeException;

class MysqliQuery implements QueryInterface
{
    public function __construct(
        private readonly mysqli_stmt $stmt,
    )
    {}

    public function execute(): void
    {
        if (!$this->stmt->execute()) {
            throw new RuntimeException('Statement execution failed: ' . $this->stmt->error);
        }
    }

    public function lastInsertId(): int
    {
        return (int) $this->stmt->insert_id;
    }

    public function fetchOne(): mixed
    {
        $result = $this->getResult();
        return $result->fetch_assoc() ?: null;
    }

    public function fetchAll(): array
    {
        $result = $this->getResult();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    private function getResult(): mysqli_result
    {
        $result = $this->stmt->get_result();
        if ($result === false) {
            throw new RuntimeException('Getting result failed: ' . $this->stmt->error);
        }
        return $result;
    }
}