<?php

namespace App\Query\Mysqli\Traits;

trait QuotingNamesTrait
{
    private function quoteMultiple(array $values): array
    {
        return array_map(fn ($value) => $this->quoteName($value), $values);
    }

    private function quoteName(string $name): string
    {
        return '`' . $name . '`';
    }
}