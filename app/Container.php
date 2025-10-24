<?php

declare(strict_types=1);


namespace App;

use App\Exceptions\Container\ContainerException;
use App\Exceptions\Container\NotFoundException;
use Psr\Container\ContainerInterface;
use ReflectionClass;
use ReflectionException;
use ReflectionParameter;

class Container implements ContainerInterface
{
    /**
     * @var (callable|string)[]
     */
    private array $entries = [];

    /**
     * @throws ReflectionException
     * @throws ContainerException
     * @throws NotFoundException
     */
    public function get(string $id)
    {
        if ($this->has($id))
        {
            $entry = $this->entries[$id];

            if (is_callable($entry)) {
                return $entry($this);
            }

            $id = $entry;
        }

        return $this->resolve($id);
    }

    public function has(string $id): bool
    {
        return isset($this->entries[$id]);
    }

    public function set(string $id, callable|string $concrete): void
    {
        $this->entries[$id] = $concrete;
    }

    /**
     * @throws ContainerException
     * @throws NotFoundException
     * @throws ReflectionException
     */
    public function resolve(string $id): mixed
    {
        $reflector = $this->getValidReflector($id);

        $constructor = $reflector->getConstructor();

        if (! $constructor) {
            return new $id;
        }

        $parameters = $constructor->getParameters();

        if (! $parameters) {
            return new $id;
        }

        $dependencies = $this->getDependencies($id, $parameters);

        return $reflector->newInstanceArgs($dependencies);
    }

    /**
     * @throws ContainerException
     * @throws NotFoundException
     */
    public function getValidReflector(string $id): ReflectionClass
    {
        try {
            $reflector = new ReflectionClass($id);
        } catch (ReflectionException $e) {
            throw new NotFoundException();
        }

        if (! $reflector->isInstantiable()) {
            throw new ContainerException("Class $id is not instantiable");
        }

        return $reflector;
    }

    private function getDependencies(string $id, array $parameters): array
    {
        return array_map(function (ReflectionParameter $parameter) use ($id) {
            return $this->resolveDependency($parameter, $id);
        }, $parameters);
    }

    /**
     * @throws ReflectionException
     * @throws ContainerException
     * @throws NotFoundException
     */
    private function resolveDependency(ReflectionParameter $parameter, string $id)
    {
        $type = $this->getValidType($parameter, $id);

        return $this->get($type->getName());
    }

    /**
     * @throws ContainerException
     */
    private function getValidType(ReflectionParameter $parameter, string $id): \ReflectionNamedType
    {
        $name = $parameter->getName();
        $type = $parameter->getType();

        if (! $type) {
            throw new ContainerException("Failed to resolve $id because parameter $name is not type");
        }

        if ($type instanceof \ReflectionUnionType) {
            throw new ContainerException("Failed to resolve $id because parameter $name is union type");
        }

        if ($type->isBuiltin()) {
            throw new ContainerException("Failed to resolve $id because parameter $name is builtin");
        }

        if (! $type instanceof \ReflectionNamedType) {
            throw new ContainerException("Failed to resolve $id because parameter $name is invalid");
        }

        return $type;
    }
}