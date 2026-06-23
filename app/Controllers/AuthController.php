<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\View;
use App\Models\User;
use PDOException;
use App\Core\Csrf;
use App\Core\Flash;

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
            Flash::set('error', 'Name, email, and password are required.');
            redirect('/register');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Flash::set('error', 'Please enter a valid email address.');
            redirect('/register');
        }

        if (strlen($password) < 8) {
            Flash::set('error', 'Password must be at least 8 characters.');
            redirect('/register');
        }

        try {
            User::create($name, $email, $password);
        } catch (PDOException $e) {
            error_log($e->getMessage());

            http_response_code(500);

            if (($_ENV['APP_ENV'] ?? 'local') === 'production') {
                Flash::set('error', 'Registration failed. Please try again later.');
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

        Flash::set('success', 'Account created. You are now logged in.');
        redirect('/polls');
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
            Flash::set('error', 'Email and password are required.');
            redirect('/login');
        }

        $user = User::findByEmail($email);

        if ($user === null || !password_verify($password, $user['password_hash'])) {
            Flash::set('error', 'Invalid email or password.');
            redirect('/login');
        }

        Auth::login((int) $user['id']);

        Flash::set('success', 'You are now logged in.');
        redirect('/polls');
    }

    public function logout(): void
    {
        Csrf::requireValid();
        Auth::logout();

        Flash::set('success', 'You have been logged out.');
        redirect('/login');
    }
}