<?php

declare(strict_types=1);

namespace App\Views;

use App\Contracts\ViewInterface;
use RuntimeException;
use Throwable;

class PhpTemplate implements ViewInterface
{
    private function __construct(
        private readonly string $templateName,
        private array $data,
    ) {}

    public static function load(
        string $templateName,
        array $data = [],
    ): static
    {
        return new static($templateName, $data);
    }


    /**
     * @throws Throwable
     */
    public function render(): string
    {
        $this->injectDataVariables();

        $path = $this->getValidPath();
        return $this->includeTemplate($path);
    }

    private function getPath(): string
    {
        return RESOURCES_DIR . '/templates/' . $this->templateName . '.php';
    }

    public function getValidPath(): string
    {
        $path = $this->getPath();

        if ( ! is_file($path)) {
            throw new RuntimeException("Template not found: {$path}");
        }

        return $path;
    }

    public function injectDataVariables(): void
    {
        extract($this->data, EXTR_SKIP);
    }

    public function includeTemplate(string $path): string|false
    {
        ob_start();
        try {
            include $path;
        } catch (Throwable $e) {
            ob_end_clean();
            throw $e;
        }

        return ob_get_clean();
    }
}
