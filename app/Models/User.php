<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

class User
{
    public static function create(string $name, string $email, string $password): bool
    {
        $db = Database::getConnection();

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $db->prepare(
            'INSERT INTO users (name, email, password_hash)
             VALUES (:name, :email, :password_hash)'
        );

        return $stmt->execute([
            'name' => $name,
            'email' => $email,
            'password_hash' => $passwordHash,
        ]);
    }

    public static function findByEmail(string $email): ?array
    {
        $db = Database::getConnection();

        $stmt = $db->prepare(
            'SELECT id, name, email, password_hash
             FROM users
             WHERE email = :email
             LIMIT 1'
        );

        $stmt->execute([
            'email' => $email,
        ]);

        $user = $stmt->fetch();

        return $user ?: null;
    }
}