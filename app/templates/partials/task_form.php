<form class="row g-3" action="/tasks<?=$action??''?>" method="<?=(!empty($method) && ($method !== 'PUT')) ? $method :'POST'?>" enctype="multipart/form-data">
  <div class="col-12">
    <label for="taskTitle" class="form-label">Title</label>
    <input type="text" class="form-control" id="taskTitle" name="title" value="<?=$task['title']??''?>" required>
  </div>
  <div class="col-12">
    <label for="taskDescription" class="form-label">Description</label>
    <input type="text" class="form-control" id="taskDescription" name="description" placeholder="Some description" value="<?=$task['description']??''?>">
  </div>
  <div class="col-auto">
    <label class="form-label visually-hidden" for="taskStatus">Status</label>
    <select class="form-select" id="taskStatus" name="status">
      <?php $status_value = empty($task) ? reset($status_options)->value : $task['status']->value; ?>
      <?php foreach($status_options as $code => $enum): ?>
        <option value="<?=$enum->value?>" <?=$status_value === $enum->value ? 'selected' : ''?>><?=$enum->name?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="col-md-6">
    <label for="completeDate" class="form-label">Complete date</label>
    <input type="date" class="form-control" id="completeDate" name="complete_date" value="<?=$task['completeDate']?$task['completeDate']->format('Y-m-d'):''?>">
  </div>
  <div class="col-md-3">
    <label for="attachedFile" class="form-label">Attach file</label>
    <input type="file" class="form-control" id="attachedFile" name="files[]" multiple>
  </div>
  <?php if(!empty($method) && ($method === 'PUT')): ?>
    <input type="hidden" name="_method" value="PUT">
  <?php endif; ?>
  <div class="col-12">
    <button type="submit" class="btn btn-primary">Create</button>
  </div>
</form>