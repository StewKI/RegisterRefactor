<?php

declare(strict_types=1);

/** @var App $app */

use app\App;

$app = require __DIR__ . '/../bootstrap.php';

$app->boot();

$app->run();
