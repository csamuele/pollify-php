<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\View;
use App\Models\Poll;
use App\Core\Csrf;
use App\Core\Flash;

class PollController
{
    public function index(): void
    {
        $polls = Poll::all();

        View::render('polls/index', [
            'title' => 'Polls',
            'polls' => $polls,
        ]);
    }

    public function create(): void
    {
        Auth::requireLogin();

        View::render('polls/create', [
            'title' => 'Create Poll',
        ]);
    }

    public function store(): void
    {
        Csrf::requireValid();
        Auth::requireLogin();

        $userId = Auth::userId();

        if ($userId === null) {
            http_response_code(401);
            echo '<h1>You must be logged in to create a poll.</h1>';
            return;
        }

        $question = trim($_POST['question'] ?? '');
        $options = $_POST['options'] ?? [];

        if ($question === '') {
            Flash::set('error', 'Question is required.');
            redirect('/polls/create');
        }

        if (!is_array($options)) {
            Flash::set('error', 'Options must be submitted as an array.');
            redirect('/polls/create');
        }

        $cleanOptions = [];

        foreach ($options as $option) {
            $option = trim((string) $option);

            if ($option !== '') {
                $cleanOptions[] = $option;
            }
        }

        if (count($cleanOptions) < 2) {
            Flash::set('error', 'Please provide at least two options.');
            redirect('/polls/create');
        }

        $pollId = Poll::create($userId, $question, $cleanOptions);

        if ($pollId === null) {
            Flash::set('error', 'Poll could not be created.');
            redirect('/polls/create');
        }

        Flash::set('success', 'Poll created successfully.');
        redirect("/polls/show?id={$pollId}");
    }

    public function show(): void
    {
        $id = (int) ($_GET['id'] ?? 0);

        if ($id <= 0) {
            http_response_code(400);
            echo '<h1>Invalid poll ID</h1>';
            return;
        }

        $poll = Poll::find($id);

        if ($poll === null) {
            http_response_code(404);
            echo '<h1>Poll not found</h1>';
            return;
        }

        $options = Poll::options($id);
        $results = Poll::results($id);

        View::render('polls/show', [
            'title' => $poll['question'],
            'poll' => $poll,
            'options' => $options,
            'results' => $results,
        ]);
    }
}