<?php

use App\Core\Auth;
use App\Core\Flash;

$flashMessages = Flash::get();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?= e($title ?? 'Pollify PHP') ?></title>
    <style>
    body {
        font-family: Arial, sans-serif;
        max-width: 800px;
        margin: 2rem auto;
        padding: 0 1rem;
        line-height: 1.5;
    }

    nav {
        margin-bottom: 1rem;
    }

    nav a,
    nav button {
        margin-right: 0.5rem;
    }

    .flash {
        padding: 0.75rem;
        margin-bottom: 1rem;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .flash-error {
        border-color: #b00020;
    }

    .flash-success {
        border-color: #1b5e20;
    }
</style>
</head>

<body>
    <header>
        <h1>Pollify PHP</h1>

        <nav>
            <a href="/">Home</a>
            <a href="/about">About</a>
            <a href="/polls">Polls</a>

            <?php if (Auth::check()): ?>
                <form method="POST" action="/logout" style="display: inline;">
                    <?= \App\Core\Csrf::field() ?>
                    <button type="submit">Logout</button>
                </form>
            <?php else: ?>
                <a href="/register">Register</a>
                <a href="/login">Login</a>
            <?php endif; ?>
        </nav>
    </header>

    <main>
        <?php foreach ($flashMessages as $type => $messages): ?>
            <?php foreach ($messages as $message): ?>
                <div class="flash flash-<?= e($type) ?>">
                    <?= e($message) ?>
                </div>
            <?php endforeach; ?>
        <?php endforeach; ?>
        <?php require $viewPath; ?>
    </main>
</body>

</html>