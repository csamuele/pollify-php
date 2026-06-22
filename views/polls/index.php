<h2>Polls</h2>

<?php if (empty($polls)): ?>
    <p>No polls have been created yet.</p>
<?php else: ?>
    <ul>
        <?php foreach ($polls as $poll): ?>
            <li>
                <a href="/polls/show?id=<?= htmlspecialchars((string) $poll['id'], ENT_QUOTES, 'UTF-8') ?>">
                    <?= htmlspecialchars($poll['question'], ENT_QUOTES, 'UTF-8') ?>
                </a>
                <br>
                <small>
                    Created at:
                    <?= htmlspecialchars($poll['created_at'], ENT_QUOTES, 'UTF-8') ?>
                </small>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>