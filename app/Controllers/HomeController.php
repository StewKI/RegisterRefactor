<?php

declare(strict_types=1);


namespace App\Controllers;

use App\View;

class HomeController
{
    public function __construct() {}

    public function index(): View
    {
        return View::raw("Dobro dosli!!!");
    }
}