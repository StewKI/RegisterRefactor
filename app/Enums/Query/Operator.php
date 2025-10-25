<?php

namespace App\Enums\Query;

enum Operator: string
{
    case AND = 'and';
    case OR = 'or';
    case GREATER = '>';
    case LESS = '<';
    case EQUAL = '=';
    case NOT_EQUAL = '!=';
    case GREATER_EQUAL = '>=';
    case LESS_EQUAL = '<=';
    case LIKE = "LIKE";
}
