<?php

declare(strict_types=1);


namespace App\Contracts;

interface DataLoaderInterface
{
    public function getData(string $name): array;
}