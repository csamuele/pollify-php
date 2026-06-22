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

    public static function find(int $id): ?array
    {
        $db = Database::getConnection();

        $stmt = $db->prepare(
            'SELECT id, question, created_at
             FROM polls
             WHERE id = :id
             LIMIT 1'
        );

        $stmt->execute([
            'id' => $id,
        ]);

        $poll = $stmt->fetch();

        return $poll ?: null;
    }

    public static function options(int $pollId): array
    {
        $db = Database::getConnection();

        $stmt = $db->prepare(
            'SELECT id, option_text
             FROM poll_options
             WHERE poll_id = :poll_id
             ORDER BY id'
        );

        $stmt->execute([
            'poll_id' => $pollId,
        ]);

        return $stmt->fetchAll();
    }
}