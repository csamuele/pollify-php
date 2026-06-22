<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Models\Ballot;
use App\Models\Poll;

class VoteController
{
    public function store(): void
    {
        Auth::requireLogin();

        $userId = Auth::userId();

        if ($userId === null) {
            http_response_code(401);
            echo '<h1>You must be logged in to vote.</h1>';
            return;
        }

        $pollId = (int) ($_POST['poll_id'] ?? 0);
        $pollOptionId = (int) ($_POST['poll_option_id'] ?? 0);

        if ($pollId <= 0 || $pollOptionId <= 0) {
            http_response_code(400);
            echo '<h1>Invalid vote data</h1>';
            return;
        }

        if (!Poll::optionBelongsToPoll($pollId, $pollOptionId)) {
            http_response_code(400);
            echo '<h1>Invalid poll option</h1>';
            return;
        }

        $created = Ballot::create($userId, $pollId, $pollOptionId);

        if (!$created) {
            http_response_code(409);
            echo '<h1>You have already voted in this poll.</h1>';
            return;
        }

        header("Location: /polls/show?id={$pollId}");
        exit;
    }
}