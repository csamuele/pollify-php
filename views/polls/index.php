<h2>Polls</h2>

<p>This page will list all polls.</p>

<ul>
    <?php foreach ($polls as $poll): ?>
        <li><?= htmlspecialchars($poll, ENT_QUOTES, 'UTF-8') ?></li>
    <?php endforeach; ?>
</ul>