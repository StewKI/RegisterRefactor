<?php

declare(strict_types=1);


namespace App\Enums\Query;

use App\Exceptions\Query\UnsupportedQueryType;

enum ParamType: string
{
    case INT = "i";
    case FLOAT = "d";
    case STRING = "s";
    case BINARY = "b";

    public static function fromValue(mixed $value): ParamType
    {
        $type = gettype($value);

        $paramType = match ($type) {
            "string" => ParamType::STRING,
            "integer" => ParamType::INT,
            "double" => ParamType::FLOAT,
            default => null,
        };

        if (! $paramType) {
            throw new UnsupportedQueryType($type);
        }

        return $paramType;
    }
}