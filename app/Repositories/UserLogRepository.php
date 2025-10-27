<?php

declare(strict_types=1);


namespace App\Repositories;

use App\Contracts\Query\QueryBuilderFactoryInterface;
use App\Contracts\Repositories\UserLogRepositoryInterface;
use App\Models\UserLog;
use App\Query\Param;
use DateTime;

class UserLogRepository implements UserLogRepositoryInterface
{
    public function __construct(
        private readonly QueryBuilderFactoryInterface $queryBuilderFactory,
    ) {}

    public function createUserLog(string $action, int $userId): UserLog
    {
        $insert = $this->queryBuilderFactory
            ->createInsertQuery(
            "user_log",
            ["action", "user_id", "log_time"],
        );

        $insert->values(
            [Param::bind($action), Param::bind($userId), Param::raw("NOW()")],
        );

        $insertQuery = $insert->build()->execute();

        return new UserLog(
            $insertQuery->lastInsertId(),
            $action,
            $userId,
            new DateTime()
        );
    }
}