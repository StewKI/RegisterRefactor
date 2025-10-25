<?php

declare(strict_types=1);


namespace App\Enums\Query;

enum Order: string
{
    case ASC = 'ASC';
    case DESC = 'DESC';
}