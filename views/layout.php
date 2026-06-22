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
        </nav>
    </header>

    <main>
        <?php require $viewPath; ?>
    </main>
</body>
</html>