<?php

declare(strict_types=1);


namespace App;

use App\Exceptions\RouteNotFoundException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class Router
{
    private array $routes = [];

    public function __construct(private readonly ContainerInterface $container) {}


    public function register(string $requestMethod, string $path, callable|array $action): self
    {
        $this->routes[$requestMethod][$path] = $action;

        return $this;
    }

    public function get(string $path, callable|array $action): self
    {
        $this->register('get', $path, $action);
        return $this;
    }

    public function post(string $path, callable|array $action): self
    {
        $this->register('post', $path, $action);
        return $this;
    }

    /**
     * @throws RouteNotFoundException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function resolve(string $requestUri, string $requestMethod): View
    {
        $route = $this->getRoute($requestUri);
        $action = $this->getValidAction($requestMethod, $route);

        if (is_callable($action)) {
            return call_user_func($action);
        }

        [$class, $method] = $action;

        if (class_exists($class)) {
            $class = $this->container->get($class);

            if (method_exists($class, $method)) {
                return call_user_func_array([$class, $method], []);
            }
        }

        throw new RouteNotFoundException();
    }

    private function getRoute(string $requestUri): string
    {
        return explode('?', $requestUri)[0];
    }

    /**
     * @return mixed|null
     * @throws RouteNotFoundException
     */
    private function getValidAction(string $requestMethod, string $route): mixed
    {
        $action = $this->routes[$requestMethod][$route] ?? null;

        if (! $action) {
            throw new RouteNotFoundException();
        }

        return $action;
    }
}