<?php

use App\Core\Auth;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title ?? 'Pollify PHP', ENT_QUOTES, 'UTF-8') ?></title>
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
            <button type="submit">Logout</button>
        </form>
    <?php else: ?>
        <a href="/register">Register</a>
        <a href="/login">Login</a>
    <?php endif; ?>
</nav>
    </header>

    <main>
        <?php require $viewPath; ?>
    </main>
</body>
</html>