<?php

declare(strict_types=1);


namespace App;

use App\Exceptions\RouteNotFoundException;
use Dotenv\Dotenv;

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

    public function run(): void
    {
        try {
            $view = $this->router->resolve($this->request['uri'], strtolower($this->request['method']));
            $view->redner();
        }
        catch (RouteNotFoundException $e) {
            http_response_code(404);

            $view = View::raw("404 Not Found");
            $view->redner();
        }
    }
}