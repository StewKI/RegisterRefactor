<?php

declare(strict_types=1);


namespace App\Utils;

use App\Contracts\DataLoaderInterface;
use JsonException;
use RuntimeException;

class JsonDataLoader implements DataLoaderInterface
{
    public function __construct(
        private readonly string $rootDir,
    ) {}

    /**
     * @throws JsonException
     */
    public function getData(string $name): array
    {
        $path = $this->getValidPath($name);
        $content = $this->getValidContent($path);

        return $this->getValidDecoded($content, $path);
    }

    /**
     * @throws JsonException
     */
    public function getValidDecoded(string $content, string $path): mixed
    {
        $decoded = json_decode(
            $content,
            associative: true,
            flags: JSON_THROW_ON_ERROR
        );
        $this->checkDecoded($decoded, $path);

        return $decoded;
    }

    public function getValidContent(string $path): string|false
    {
        $content = file_get_contents($path);
        $this->checkContent($content, $path);

        return $content;
    }

    public function getValidPath(string $name): string
    {
        $path = $this->getFilePath($name);
        $this->checkPath($path);

        return $path;
    }

    private function getFilePath(string $name): string
    {
        return $this->rootDir . DIRECTORY_SEPARATOR . $name . '.json';
    }

    private function checkDecoded(mixed $decoded, string $path): void
    {
        if (!is_array($decoded)) {
            throw new RuntimeException("Invalid JSON structure in {$path}");
        }
    }

    private function checkContent(string|false $content, string $path): void
    {
        if ($content === false) {
            throw new RuntimeException("Failed to read file: $path");
        }
    }

    private function checkPath(string $path): void
    {
        if (!file_exists($path)) {
            throw new RuntimeException("JSON file not found: $path");
        }
    }
}