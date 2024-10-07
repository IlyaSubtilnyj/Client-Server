<?php $this->layout('base', ['title' => 'Task page']); ?>

<?php $this->start('main') ?>
    <?php if(is_null($task)): ?>
        No such task
    <?php else: ?>
        <?= $this->insert('partials/task_form', ['task' => $task, 'method' => 'PUT', 'action' => '/'.$task['id'], 'status_options' => $status_options, 'selected_status_option' => $task['status']->value]) ?>
        <ul>
            <?php foreach ($files as $file): ?>
                <li>
                    <a href="<?= htmlspecialchars($file) ?>" download>
                        <?= htmlspecialchars($file) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
<?php $this->stop() ?>