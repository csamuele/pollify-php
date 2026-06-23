<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Models\Ballot;
use App\Models\Poll;
use App\Core\Csrf;
use App\Core\Flash;

class VoteController
{
    public function store(): void
    {
        Csrf::requireValid();
        Auth::requireLogin();

        $userId = Auth::userId();

        if ($userId === null) {
            Flash::set('error', 'You must be logged in to vote.');
            redirect('/login');
        }

        $pollId = (int) ($_POST['poll_id'] ?? 0);
        $pollOptionId = (int) ($_POST['poll_option_id'] ?? 0);

        if ($pollId <= 0 || $pollOptionId <= 0) {
            Flash::set('error', 'Invalid vote data.');
            redirect('/polls');
        }

        if (!Poll::optionBelongsToPoll($pollId, $pollOptionId)) {
            Flash::set('error', 'Invalid poll option.');
            redirect('/polls');
        }

        $created = Ballot::create($userId, $pollId, $pollOptionId);

        if (!$created) {
            Flash::set('error', 'You have already voted in this poll.');
            redirect("/polls/show?id={$pollId}");
        }

        Flash::set('success', 'Vote submitted successfully.');
        redirect("/polls/show?id={$pollId}");
    }
}