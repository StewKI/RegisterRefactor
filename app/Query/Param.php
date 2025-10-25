<?php

declare(strict_types=1);

namespace App\Query;

use App\Contracts\Query\QueryParamInterface;
use App\Enums\Query\ParamType;

class Param implements QueryParamInterface
{
    private function __construct(
        private readonly mixed $value,
        private readonly ParamType $type,
        private readonly bool $bindable,
    )
    {}

    public function isBindable(): bool
    {
        return $this->bindable;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function getType(): ParamType
    {
        return $this->type;
    }

    public static function raw(string $value): self
    {
        return new self($value, ParamType::STRING, bindable: false);
    }

    public static function bind(mixed $value): self
    {
        $type = ParamType::fromValue($value);
        return new self($value, $type, bindable: true);
    }

    /**
     * @param array $values
     *
     * @return self[]
     */
    public static function bindList(array $values): array
    {
        return array_map(fn ($value) => self::bind($value), $values);
    }
}