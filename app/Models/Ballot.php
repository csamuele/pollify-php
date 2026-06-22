<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDOException;

class Ballot
{
    public static function create(int $userId, int $pollId, int $pollOptionId): bool
    {
        $db = Database::getConnection();

        try {
            $stmt = $db->prepare(
                'INSERT INTO ballots (user_id, poll_id, poll_option_id)
                 VALUES (:user_id, :poll_id, :poll_option_id)'
            );

            return $stmt->execute([
                'user_id' => $userId,
                'poll_id' => $pollId,
                'poll_option_id' => $pollOptionId,
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }
}