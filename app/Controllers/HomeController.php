<?php

declare(strict_types=1);


namespace App\Controllers;

use App\Contracts\ViewInterface;
use App\Request;
use App\Views\Redirect;

class HomeController
{
    public function __construct() {}

    public function index(Request $request): ViewInterface
    {
        return Redirect::to("/register");
    }
}