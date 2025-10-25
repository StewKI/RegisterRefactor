<?php

declare(strict_types=1);


namespace App\Views;

use JsonException;

class JsonView extends View
{
    /**
     * @throws JsonException
     */
    protected function __construct(array $data)
    {
        $json = json_encode($data, JSON_THROW_ON_ERROR);
        parent::__construct($json);
    }

    /**
     * @throws JsonException
     */
    public static function make(array $data): static
    {
        return new static($data);
    }

    public function render(): string
    {
        header('Content-type: application/json');
        return parent::render();
    }
}