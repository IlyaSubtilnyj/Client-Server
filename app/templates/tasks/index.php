<?php $this->layout('base', ['title' => 'Tasks']); ?>

<?php $this->start('main') ?>
<form method="GET">
    <div class="col-3">
        <label class="form-label" for="filterProperty">Filter by status: </label>
        <select class="form-select" id="filterProperty" name="filter">
        <option value="" <?= is_null($selected_option) ? 'selected' : ''?>>No filter</option>
        <?php foreach($status_options as $code => $enum): ?>
            <option value="<?=$enum->value?>"<?=$selected_option == $enum ? 'selected' : ''?>><?=$enum->name?></option>
        <?php endforeach; ?>
        </select>
    </div>
    <div class="col-9">
        <button type="submit" class="btn btn-primary">Apply</button>
    </div>
</form>
<ul>
    <?php foreach($tasks as $task): ?>
        <?= $this->insert('partials/task_card', ['task' => $task]); ?>
    <?php endforeach; ?>
</ul>
<?php $this->stop() ?>
