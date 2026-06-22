<?php

declare(strict_types=1);

namespace App\Core;

class Csrf
{
    public static function token(): string
    {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        return $_SESSION['csrf_token'];
    }

    public static function field(): string
    {
        return '<input type="hidden" name="csrf_token" value="' . e(self::token()) . '">';
    }

    public static function validate(?string $token): bool
    {
        if (!isset($_SESSION['csrf_token']) || $token === null) {
            return false;
        }

        return hash_equals($_SESSION['csrf_token'], $token);
    }

    public static function requireValid(): void
    {
        if (!self::validate($_POST['csrf_token'] ?? null)) {
            http_response_code(419);
            echo '<h1>Invalid security token. Please go back and try again.</h1>';
            exit;
        }
    }
}