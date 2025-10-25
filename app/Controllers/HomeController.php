<?php

declare(strict_types=1);


namespace App\Controllers;

use App\Contracts\ViewInterface;
use App\Request;
use App\Views\Redirect;
use app\Views\View;

class HomeController
{
    public function __construct() {}

    public function index(Request $request): ViewInterface
    {
        return Redirect::to("/register");
    }
}