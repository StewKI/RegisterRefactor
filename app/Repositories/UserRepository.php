<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Query\QueryBuilderFactoryInterface;
use App\Contracts\Repositories\UserRepositoryInterface;
use App\Models\User;
use App\Query\Param;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(
        private readonly QueryBuilderFactoryInterface $queryBuilderFactory,
    ) {}

    public function createUser(
        string $email,
        string $password
    ): User
    {
        $insert = $this->queryBuilderFactory
            ->createInsertQuery("user", ["email", "password"]);

        $insert->values(Param::bindList([$email, $password]));

        $insertQuery = $insert->build()->execute();

        return new User(
            $insertQuery->lastInsertId(),
            $email,
            $password
        );
    }

    public function emailExists(string $email): bool
    {
        $select = $this->queryBuilderFactory
            ->createSelectQuery("user", ["email"]);

        $select->where("email", Param::bind($email));

        $selectQuery = $select->build()->execute();
        $rows = $selectQuery->fetchAll();

        return count($rows) > 0;
    }

    public function getUserById(int $userId): ?User
    {
        $select = $this->queryBuilderFactory
            ->createSelectQuery("user", ["id", "email", "password"]);

        $select->where("id", Param::bind($userId));

        $selectQuery = $select->build()->execute();
        $row = $selectQuery->fetchOne();

        if (!is_array($row)) {
            return null;
        }

        return new User(
            $row["id"],
            $row["email"],
            $row["password"]
        );
    }
}