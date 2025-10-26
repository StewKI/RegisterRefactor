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

$container->set(Config::class, fn() => $config);
$container_bindings($container);

return $container;
