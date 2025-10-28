<?php

declare(strict_types=1);


namespace App;

use App\Exceptions\RouteNotFoundException;
use App\Views\View;

class App
{
    public function __construct(
        private readonly Router $router,
        private readonly array $request = [],
    ) {}


    public function run(): void
    {
        try {
            $view = $this->router->resolve($this->request['uri'], strtolower($this->request['method']));

            echo $view->render();
        }
        catch (RouteNotFoundException $e) {
            http_response_code(404);

            $view = View::raw("404 Not Found");
            echo $view->render();
        }
    }
}