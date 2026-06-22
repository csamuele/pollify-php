<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\View;

class HomeController
{
    public function index(): void
    {
        View::render('home', [
            'title' => 'Home',
            'appName' => 'Pollify PHP',
        ]);
    }

    public function about(): void
    {
        View::render('about', [
            'title' => 'About',
        ]);
    }
}