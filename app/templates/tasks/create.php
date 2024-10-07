<?php $this->layout('base', ['title' => 'Create auction']); ?>

<?php $this->start('main') ?>
    <?= $this->insert('partials/task_form', ['status_options' => $status_options]) ?>
<?php $this->stop() ?>