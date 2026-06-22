<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\View;
use App\Models\Poll;

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