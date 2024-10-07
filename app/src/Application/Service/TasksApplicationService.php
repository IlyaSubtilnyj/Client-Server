<?php

namespace Application\Service;

use Application\Command\StoreTaskCommand;
use Application\Query\ShowAllTasksQuery;
use Application\Query\ShowTaskQuery;
use Application\Command\UpdateTaskCommand;
use Domain\Model\Entity\Task;
use Infrastructure\Service\TasksAttachedFilesService;

class TasksApplicationService
{
    private ?TaskCollectionService $taskCollectionService;

    public function __construct()
    {
        $this->taskCollectionService = new TaskCollectionService;
    }

    public function showAllTasks(ShowAllTasksQuery $query): array
    {
        $tasks = Task::all();
        
        if($query->getFilter()) {

            $tasks = $this->taskCollectionService->for($tasks)->filter($query->getFilter())->_();
        }

        return $tasks;
    }


    public function showTask(ShowTaskQuery $query): array
    {

        $title = $query->getTitle();

        $task = Task::findByTitle(title: $title);

        if(is_null($task)) {

            return [null, null];
        }

        $files = glob('uploads/files/'.$task->id.'_*');

        return [$task, $files];
    }

    public function updateTask(UpdateTaskCommand $command): ?string {

        $task = Task::find($command->getTaskId());

        if(is_null($task)) {

            return null;
        }

        $task->title        = $command->getTitle();
        $task->description  = $command->getDescription();
        $task->completeDate = $command->getCompleteDate();
        $task->status       = $command->getStatus();
    
        if (isset($_FILES['files'])) {
        
            $tasksAttachFilesApplicationService = new TasksAttachedFilesService;

            $tasksAttachFilesApplicationService->attachFiles($task, $_FILES['files']);
        }

        $task->update();

        return $task->title;
    }

    public function storeTask(StoreTaskCommand $command): void {

        $task = new Task(
            title: $command->getTitle(), 
            description: $command->getDescription(),
            complete_date: $command->getCompleteDate(), 
            status: $command->getStatus(),
        );
        
        $task->save();

        if (isset($_FILES['files'])) {

            $tasksAttachFilesApplicationService = new TasksAttachedFilesService;

            $tasksAttachFilesApplicationService->attachFiles($task, $_FILES['files']);
        }
    }
}