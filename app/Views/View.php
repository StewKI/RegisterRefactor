<?php

declare(strict_types=1);


namespace app\Views;

use App\Contracts\ViewInterface;

class View implements ViewInterface
{
    private string $content;

    protected function __construct(string $content)
    {
        $this->content = $content;
    }

    public static function raw(string $content): View
    {
        return new View($content);
    }

    public function render(): string
    {
        return $this->content;
    }
}