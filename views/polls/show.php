<h2><?= htmlspecialchars($poll['question'], ENT_QUOTES, 'UTF-8') ?></h2>

<?php if (empty($options)): ?>
    <p>This poll does not have any options yet.</p>
<?php else: ?>
    <form method="POST" action="/vote">
        <input type="hidden" name="poll_id" value="<?= htmlspecialchars((string) $poll['id'], ENT_QUOTES, 'UTF-8') ?>">

        <?php foreach ($options as $option): ?>
            <div>
                <label>
                    <input
                        type="radio"
                        name="poll_option_id"
                        value="<?= htmlspecialchars((string) $option['id'], ENT_QUOTES, 'UTF-8') ?>"
                        required
                    >
                    <?= htmlspecialchars($option['option_text'], ENT_QUOTES, 'UTF-8') ?>
                </label>
            </div>
        <?php endforeach; ?>

        <button type="submit">Vote</button>
    </form>
<?php endif; ?>

<h3>Results</h3>

<?php if (empty($results)): ?>
    <p>No results yet.</p>
<?php else: ?>
    <ul>
        <?php foreach ($results as $result): ?>
            <li>
                <?= htmlspecialchars($result['option_text'], ENT_QUOTES, 'UTF-8') ?>:
                <?= htmlspecialchars((string) $result['vote_count'], ENT_QUOTES, 'UTF-8') ?>
                vote(s)
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<p>
    <a href="/polls">Back to polls</a>
</p>