<?php

declare(strict_types=1);

use App\Core\Router;

require_once __DIR__ . '/../vendor/autoload.php';

$router = new Router();

$router->get('/', 'HomeController@index');
$router->get('/about', 'HomeController@about');
$router->get('/polls', 'PollController@index');

$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);