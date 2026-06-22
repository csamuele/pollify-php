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
    public static function optionBelongsToPoll(int $pollId, int $optionId): bool
{
    $db = Database::getConnection();

    $stmt = $db->prepare(
        'SELECT id
         FROM poll_options
         WHERE id = :option_id
           AND poll_id = :poll_id
         LIMIT 1'
    );

    $stmt->execute([
        'option_id' => $optionId,
        'poll_id' => $pollId,
    ]);

    return (bool) $stmt->fetch();
}
public static function results(int $pollId): array
{
    $db = Database::getConnection();

    $stmt = $db->prepare(
        'SELECT
            poll_options.id,
            poll_options.option_text,
            COUNT(ballots.id) AS vote_count
         FROM poll_options
         LEFT JOIN ballots
            ON ballots.poll_option_id = poll_options.id
         WHERE poll_options.poll_id = :poll_id
         GROUP BY poll_options.id, poll_options.option_text
         ORDER BY poll_options.id'
    );

    $stmt->execute([
        'poll_id' => $pollId,
    ]);

    return $stmt->fetchAll();
}
}