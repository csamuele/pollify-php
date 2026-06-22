<h2>Polls</h2>

<p>
    <a href="/polls/create">Create a new poll</a>
</p>

<?php if (empty($polls)): ?>
    <p>No polls have been created yet.</p>
<?php else: ?>
    <ul>
        <?php foreach ($polls as $poll): ?>
            <li>
                <a href="/polls/show?id=<?= e((string) $poll['id']) ?>">
                    <?= e($poll['question']) ?>
                </a>
                <br>
                <small>
                    Created at:
                    <?= e($poll['created_at']) ?>
                </small>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>