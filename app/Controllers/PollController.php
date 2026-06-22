<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\View;

class PollController
{
    public function index(): void
    {
        View::render('polls/index', [
            'title' => 'Polls',
            'polls' => [
                'Favorite programming language?',
                'Best pizza topping?',
                'Tabs or spaces?',
            ],
        ]);
    }
}