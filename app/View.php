<?php

declare(strict_types=1);


namespace App;

class View
{
    private string $content;

    private function __construct(string $content)
    {
        $this->content = $content;
    }

    public static function raw(string $content): View
    {
        return new View($content);
    }

    public function redner(): void
    {
        echo $this->content;
    }
}