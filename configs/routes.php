<?php

declare(strict_types=1);


use App\Controllers\HomeController;
use App\Controllers\RegisterController;
use App\Router;

return function (Router $router)
{
    $router->get('/', [HomeController::class, 'index']);
    $router->get('/register', [RegisterController::class, 'index']);
    $router->post('/register', [RegisterController::class, 'register']);
};