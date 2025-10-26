<?php

declare(strict_types=1);

/** @var ContainerInterface $container */

use App\App;
use App\Config;
use App\Contracts\Services\Mail\SendQueuedMailsServiceInterface;
use App\Router;
use Psr\Container\ContainerInterface;

$container = require __DIR__ . '/../bootstrap.php';

$config = $container->get(Config::class);
$app = new App($config, new Router($container));

$app->boot();

/** @var SendQueuedMailsServiceInterface $sender */
$sender = $container->get(SendQueuedMailsServiceInterface::class);

$sender->sendQueuedMails();


