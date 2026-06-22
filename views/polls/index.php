<h2>Polls</h2>

<?php if (empty($polls)): ?>
    <p>No polls have been created yet.</p>
<?php else: ?>
    <ul>
        <?php foreach ($polls as $poll): ?>
            <li>
                <strong>
                    <?= htmlspecialchars($poll['question'], ENT_QUOTES, 'UTF-8') ?>
                </strong>
                <br>
                <small>
                    Created at:
                    <?= htmlspecialchars($poll['created_at'], ENT_QUOTES, 'UTF-8') ?>
                </small>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>