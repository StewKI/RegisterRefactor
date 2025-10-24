<?php

declare(strict_types=1);


use App\Controllers\HomeController;
use App\Router;

return function (Router $router)
{
    $router->get('/', [HomeController::class, 'index']);
};