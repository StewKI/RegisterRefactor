<?php

declare(strict_types=1);

use App\App;
use App\Config;
use App\Container;
use App\Router;
use Dotenv\Dotenv;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/configs/constants.php';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$config = new Config($_ENV);

$container_bindings = require CONFIG_DIR . '/container_bindings.php';

$container = new Container();
$container_bindings($container);

$router = new Router($container);

$set_routes = require CONFIG_DIR . '/routes.php';
$set_routes($router);

$app = new App($config, $router, [
    'uri' => $_SERVER['REQUEST_URI'],
    'method' => $_SERVER['REQUEST_METHOD'],
]);

return $app;