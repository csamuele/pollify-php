<?php

declare(strict_types=1);

use App\Core\Router;
use App\Core\View;

require_once __DIR__ . '/../vendor/autoload.php';

$router = new Router();

$router->get('/', function (): void {
    View::render('home', [
        'title' => 'Home',
        'appName' => 'Pollify PHP',
    ]);
});

$router->get('/about', function (): void {
    View::render('about', [
        'title' => 'About',
    ]);
});

$router->get('/polls', function (): void {
    View::render('polls/index', [
        'title' => 'Polls',
        'polls' => [
            'Favorite programming language?',
            'Best pizza topping?',
            'Tabs or spaces?',
        ],
    ]);
});

$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);