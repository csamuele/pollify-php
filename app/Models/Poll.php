<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

class Poll
{
    public static function all(): array
    {
        $db = Database::getConnection();

        $stmt = $db->query(
            'SELECT id, question, created_at
             FROM polls
             ORDER BY created_at DESC'
        );

        return $stmt->fetchAll();
    }
}