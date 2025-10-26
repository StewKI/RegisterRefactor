<?php

declare(strict_types=1);

namespace App\Views;

use App\Contracts\ViewInterface;
use RuntimeException;

class PhpTemplate implements ViewInterface
{
    private function __construct(
        private readonly string $templateName,
        private array $data = [],
    ) {}

    public static function load(
        string $templateName,
        array $data = [],
    ): static
    {
        return new static($templateName, $data);
    }


    public function render(): string
    {
        $path = $this->getPath();

        if (!is_file($path)) {
            throw new RuntimeException("Template not found: {$path}");
        }

        // Extract variables into local scope for the template
        extract($this->data, EXTR_SKIP);

        // Capture output buffer
        ob_start();
        try {
            include $path;
        } catch (\Throwable $e) {
            ob_end_clean();
            throw $e;
        }

        return ob_get_clean();
    }

    private function getPath(): string
    {
        return RESOURCES_DIR . '/templates/' . $this->templateName . '.php';
    }
}
