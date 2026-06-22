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
}