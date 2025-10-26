<?php

declare(strict_types=1);

/** @var ContainerInterface $container */

use App\App;
use App\Config;
use App\Router;
use Psr\Container\ContainerInterface;

$container = require __DIR__ . '/../bootstrap.php';

$router = new Router($container);

$set_routes = require CONFIG_DIR . '/routes.php';
$set_routes($router);

$config = $container->get(Config::class);

$app = new App($config, $router, [
    'uri' => $_SERVER['REQUEST_URI'],
    'method' => $_SERVER['REQUEST_METHOD'],
]);

$app->boot();

$app->run();
