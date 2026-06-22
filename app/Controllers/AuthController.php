<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\View;
use App\Models\User;
use PDOException;
use App\Core\Csrf;

class AuthController
{
    public function showRegister(): void
    {
        View::render('auth/register', [
            'title' => 'Register',
        ]);
    }

    public function register(): void
    {
        Csrf::requireValid();
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($name === '' || $email === '' || $password === '') {
            http_response_code(400);
            echo '<h1>Name, email, and password are required.</h1>';
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            echo '<h1>Please enter a valid email address.</h1>';
            return;
        }

        if (strlen($password) < 8) {
            http_response_code(400);
            echo '<h1>Password must be at least 8 characters.</h1>';
            return;
        }

        try {
            User::create($name, $email, $password);
        } catch (PDOException $e) {
            error_log($e->getMessage());

            http_response_code(500);

            if (($_ENV['APP_ENV'] ?? 'local') === 'production') {
                echo '<h1>Registration failed. Check the app logs for details.</h1>';
            } else {
                echo '<h1>Registration failed</h1>';
                echo '<pre>' . e($e->getMessage()) . '</pre>';
            }

            return;
        }

        $user = User::findByEmail($email);

        if ($user === null) {
            http_response_code(500);
            echo '<h1>Account created, but login failed.</h1>';
            return;
        }

        Auth::login((int) $user['id']);

        header('Location: /polls');
        exit;
    }

    public function showLogin(): void
    {
        View::render('auth/login', [
            'title' => 'Login',
        ]);
    }

    public function login(): void
    {
        Csrf::requireValid();
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($email === '' || $password === '') {
            http_response_code(400);
            echo '<h1>Email and password are required.</h1>';
            return;
        }

        $user = User::findByEmail($email);

        if ($user === null || !password_verify($password, $user['password_hash'])) {
            http_response_code(401);
            echo '<h1>Invalid email or password.</h1>';
            return;
        }

        Auth::login((int) $user['id']);

        header('Location: /polls');
        exit;
    }

    public function logout(): void
    {
        Csrf::requireValid();
        Auth::logout();

        header('Location: /login');
        exit;
    }
}