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
        $insert = $this->queryBuilderFactory->createInsertQuery("user", ["email", "password"]);

        $insert->values(Param::bindList([$email, $password]));

        $insertQuery = $insert->build();
        $insertQuery->execute();

        return new User(
            $insertQuery->lastInsertId(),
            $email,
            $password
        );
    }

    public function emailExists(string $email): bool
    {
        $select = $this->queryBuilderFactory->createSelectQuery("user", ["email"]);

        $select->where("email", Param::bind($email));

        $selectQuery = $select->build();
        $selectQuery->execute();

        $rows = $selectQuery->fetchAll();

        return count($rows) > 0;
    }
}