<?php

declare(strict_types=1);

/** @var ContainerInterface $container */

use App\Contracts\Services\Mail\SendQueuedMailsServiceInterface;
use Psr\Container\ContainerInterface;

$container = require __DIR__ . '/../bootstrap.php';

/** @var SendQueuedMailsServiceInterface $sender */
$sender = $container->get(SendQueuedMailsServiceInterface::class);

$sender->sendQueuedMails();


