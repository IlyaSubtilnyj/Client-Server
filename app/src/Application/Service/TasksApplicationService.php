<?php

namespace Application\Service;

use Application\Query\ShowAllTasksQuery;
use Domain\Model\Entity\Task;

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
}