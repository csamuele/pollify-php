<?php

declare(strict_types=1);

use App\Core\Router;
use Dotenv\Dotenv;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->safeLoad();

session_start();

$router = new Router();

$router->get('/', 'HomeController@index');
$router->get('/about', 'HomeController@about');
$router->get('/polls', 'PollController@index');
$router->get('/polls/show', 'PollController@show');
$router->post('/vote', 'VoteController@store');

$router->get('/register', 'AuthController@showRegister');
$router->post('/register', 'AuthController@register');

$router->get('/login', 'AuthController@showLogin');
$router->post('/login', 'AuthController@login');

$router->post('/logout', 'AuthController@logout');

$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);