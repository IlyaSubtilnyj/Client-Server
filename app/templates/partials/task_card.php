<li>
    Title: <?= $this->e($task['title']) ?>
    Description: <?= $this->e($task['description']) ?>
    Status: <?= $task['status']->name ?>
    Complete date: <?= $this->e($task['completeDate']->format('Y-m-d')); ?>
</li>