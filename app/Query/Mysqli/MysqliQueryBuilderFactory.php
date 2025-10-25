<?php

declare(strict_types=1);

namespace App\Query\Mysqli;

use App\Contracts\Query\Builder\InsertQueryBuilderInterface;
use App\Contracts\Query\Builder\SelectQueryBuilderInterface;
use App\Contracts\Query\Builder\UpdateQueryBuilderInterface;
use App\Contracts\Query\QueryBuilderFactoryInterface;
use App\Query\InsertQueryBuilder;
use App\Query\Mysqli\BuildStrategy\MysqliInsertBuildStrategy;
use App\Query\Mysqli\BuildStrategy\MysqliSelectBuildStrategy;
use App\Query\Mysqli\BuildStrategy\MysqliUpdateBuildStrategy;
use App\Query\SelectQueryBuilder;
use App\Query\UpdateQueryBuilder;
use mysqli;

class MysqliQueryBuilderFactory implements QueryBuilderFactoryInterface
{
    public function __construct(private readonly mysqli $mysqli) {}

    public function createSelectQuery(
        string $table,
        array $fields
    ): SelectQueryBuilderInterface {
        return new SelectQueryBuilder(
            new MysqliSelectBuildStrategy($this->mysqli),
            $table,
            $fields
        );
    }

    public function createUpdateQuery(string $table
    ): UpdateQueryBuilderInterface {
        return new UpdateQueryBuilder(
            new MysqliUpdateBuildStrategy($this->mysqli),
            $table
        );
    }

    public function createInsertQuery(
        string $table,
        array $fields
    ): InsertQueryBuilderInterface {
        return new InsertQueryBuilder(
            new MysqliInsertBuildStrategy($this->mysqli),
            $table,
            $fields
        );
    }
}