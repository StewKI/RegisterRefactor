<?php

declare(strict_types=1);


namespace App\Contracts\Query;

use app\Contracts\Query\Builder\InsertQueryBuilderInterface;
use app\Contracts\Query\Builder\SelectQueryBuilderInterface;
use app\Contracts\Query\Builder\UpdateQueryBuilderInterface;

interface QueryBuilderFactoryInterface
{
    public function createSelectQuery(string $table, array $fields): SelectQueryBuilderInterface;
    public function createUpdateQuery(string $table): UpdateQueryBuilderInterface;
    public function createInsertQuery(string $table, array $fields): InsertQueryBuilderInterface;
}