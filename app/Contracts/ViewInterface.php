<?php

declare(strict_types=1);


namespace App\Contracts;

interface ViewInterface
{
    public function render(): string;
}