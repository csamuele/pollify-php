<h2><?= e($poll['question']) ?></h2>

<?php if (empty($options)): ?>
    <p>This poll does not have any options yet.</p>
<?php else: ?>
    <form method="POST" action="/vote">
        <?= \App\Core\Csrf::field() ?>
        <input type="hidden" name="poll_id" value="<?= e((string) $poll['id']) ?>">

        <?php foreach ($options as $option): ?>
            <div>
                <label>
                    <input
                        type="radio"
                        name="poll_option_id"
                        value="<?= e((string) $option['id']) ?>"
                        required
                    >
                    <?= e($option['option_text']) ?>
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
                <?= e($result['option_text']) ?>:
                <?= e((string) $result['vote_count']) ?>
                vote(s)
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<p>
    <a href="/polls">Back to polls</a>
</p>