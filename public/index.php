<?php

declare(strict_types=1);

/** @var ContainerInterface $container */

use App\App;
use App\Contracts\SessionInterface;
use App\Router;
use Psr\Container\ContainerInterface;

$container = require __DIR__ . '/../bootstrap.php';

/** @var SessionInterface $session */
$session = $container->get(SessionInterface::class);
$session->startIfNeeded();

$router = new Router($container);

$set_routes = require CONFIG_DIR . '/routes.php';
$set_routes($router);

$app = new App($router, [
    'uri' => $_SERVER['REQUEST_URI'],
    'method' => $_SERVER['REQUEST_METHOD'],
]);

$app->run();
