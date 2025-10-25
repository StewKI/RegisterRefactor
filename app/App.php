<?php

declare(strict_types=1);


namespace App;

use App\Exceptions\RouteNotFoundException;
use App\Views\View;

class App
{
    private static DB $db;

    public function __construct(
        private readonly Config $config,
        private readonly Router $router,
        private readonly array $request = [],
    ) {}


    public function boot(): static
    {
        static::$db = new DB($this->config->db);
        return $this;
    }

    public static function getDb(): DB
    {
        return static::$db;
    }

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