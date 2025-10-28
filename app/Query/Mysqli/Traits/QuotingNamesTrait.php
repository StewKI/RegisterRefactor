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
        if ($this->quoteWhiteList($name)) {
            return $name;
        }

        return '`' . $name . '`';
    }

    private function quoteWhiteList(string $name): bool
    {
        $whiteList = ["*"];
        return in_array($name, $whiteList);
    }
}